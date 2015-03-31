# Flohmarkt
Flohmarkt Kassen &amp; Abrechnungs Tool

This tool is a simple PHP script with mySQL database backend
for registering sales at a flea market, organized by sellers by number.
Every seller has a unique number per event. 

First, create an event. Then add a sales basket by entering
the unique number (i.e. 112) and the price, divided by an asterisk:
```112*0,5``` -> add 50 cents to seller 112.
When all items are entered, submit, without any values.
The tool will then show a total for this transaction.
For the next customer, just start entering IDs and prices again.

To get a total for one event, click on the event date.
Net prices is for payout to the seller, minus the provison for
the organizer.
