#!/opt/virtualenv/URBot/bin/python
from discord import Webhook, RequestsWebhookAdapter
import discord
from discord.embeds import Embed
from settings import webhook_url, logo_url
from const import *
import cgi
import cgitb

# Logging
cgitb.enable(display=0, logdir="/usr/local/log/cgi")
form = cgi.FieldStorage()

""" Process form data to create the webhook payload. """
def get_payload() -> str:
    with open("modele_fiche_planning.txt", 'r', encoding="utf8") as f:
        model = f.read()

    info, reactions = model.split("[")
    payload = info.format(
        type=form['jdr_type'].value,
        title=form['jdr_title'].value,
        date="Le " + form['jdr_date'].value,
        length=form['jdr_length'].value,
        pseudoMJ=f"<@{form['user_id'].value}> [{form['pseudo'].value}]",
        system=form['jdr_system'].value,
        minors_allowed=minorsAllowed_to_str[int(form['jdr_pj'].value)],
        platforms=" ".join(form.getlist('platform')),
        details=form['jdr_details'].value if 'jdr_details' in form.keys() else ""
    )

    return payload

def get_webhook_url() -> str:
    return form['webhook_url'].value


if __name__ == '__main__':
    webhook = Webhook.from_url(get_webhook_url(), adapter=RequestsWebhookAdapter())
    webhook.send(
        "",
        allowed_mentions=discord.AllowedMentions(users=True),
        embed=discord.Embed(description=get_payload(), type="rich").set_thumbnail(url=logo_url),
    )
    # Redirects to main page
    print("Status: 303 See other")
    print(f"Location: http://urplanning.unionrolistes.fr?webhook={get_webhook_url()}")
    print()