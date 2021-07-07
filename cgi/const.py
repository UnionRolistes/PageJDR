from enum import IntEnum


class MinorsAllowed(IntEnum):
    YES = 0
    NO = 1
    PREFFERED = 2
    NOT_RECOMMANDED = 3


minorsAllowed_to_str = {
    MinorsAllowed.YES: "oui",
    MinorsAllowed.NO: "non",
    MinorsAllowed.PREFFERED: "préférable",
    MinorsAllowed.NOT_RECOMMANDED: "non recommandé"
}


class ScenarioType(IntEnum):
    INITIATION = 0
    ONESHOT = 1
    SCENARIO = 2
    CAMPAIGN = 3


scenarioType_to_str = {
    ScenarioType.INITIATION: "Initiation",
    ScenarioType.ONESHOT: "OneShot",
    ScenarioType.SCENARIO: "Scénario",
    ScenarioType.CAMPAIGN: "Campagne"
}