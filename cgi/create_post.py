#!/opt/virtualenv/URBot/bin/python
from os import path

from discord import Webhook, RequestsWebhookAdapter
import discord
from settings import logo_url
from const import *
import cgi
import cgitb
from urpy.xml import Calendar
from urpy import utils

# Logging
cgitb.enable(display=1)  # , logdir="/usr/local/log/cgi")


def get_payload(form) -> str:
    """ Process form data to create the webhook payload. """
    with open("modele_fiche_planning.txt", 'r', encoding="utf8") as f:
        model = f.read()

    # determines which values to show for the number of players
    maxP = form.getvalue('maxJoueurs')
    minP = form.getvalue('minJoueurs')
    if maxP == minP:
        players = maxP
    else:
        players = f"{maxP} (min {minP})"

    info, reactions = model.split("[")
    payload = info.format(
        type=form.getvalue('jdr_type'),
        title=form.getvalue('jdr_title'),
        date="Le " + form.getvalue('jdr_date'),
        players=players,
        length=form.getvalue('jdr_length'),
        pseudoMJ=f"<@{form.getvalue('user_id')}> [{form.getvalue('pseudo')}]",  # TODO handle server nicknames
        system=form.getvalue('jdr_system') + form.getvalue('jdr_system_other'),
        minors_allowed=minorsAllowed_to_str[int(form.getvalue('jdr_pj'))],
        platforms=" ".join(form.getlist('platform')),
        details=form.getvalue('jdr_details')

    )

    return payload


def get_webhook_url() -> str:
    return form.getvalue('webhook_url')


if __name__ == '__main__':
    form = cgi.FieldStorage()
    webhook_url = form.getvalue('webhook_url')
    if webhook_url:
        webhook = Webhook.from_url(get_webhook_url(), adapter=RequestsWebhookAdapter())
        msg = webhook.send(
            "",
            allowed_mentions=discord.AllowedMentions(users=True),
            embed=discord.Embed(description=get_payload(form), type="rich").set_thumbnail(url=logo_url),
        )
        calendar = Calendar(path.abspath('../Calendar/data/events.xml'))
        calendar.add_event(form, msg)  # TODO maybe move webhook processing to urpy
        calendar.save()
        # Redirects to main page
        utils.html_header_relocate(f"http://urplanning.unionrolistes.fr?webhook={get_webhook_url()}")
    else:
        utils.html_header_webhook_not_supplied()

