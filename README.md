# HSR-Subscriber


Subscribing to alerts and anomalies in the Hamilton Street Railway bus system

## Proposed Idea

Knowing for certain when a bus will arrive ahead of time is a valuable service for regular transit users. Having this information can make the difference between waiting in the cold for a late bus and waiting inside until its arrival time. HSR Subscriber allows frequent transit users to receive alerts regarding the status of their bus ahead of time, allowing them to modify their routine accordingly and catch the bus.

## Basic Function

To create a transit alert for a particular stop, users will text a message to an automated number that includdes the `Stop ID`, `Route Number`, `Scheduled Time`, and `Days of Week`. The service will filter the information, create an alert, and reply back to the user with a confirmation message.

For example, a user might text `subscribe to Stop 1145, Route 51, 4:45pm, weekdays`
The automated reply would state `Subscription confirmed for HSR Bus Stop 1145 (MAIN AT EMERSON), Route 51 (UNIVERSITY, EASTBOUND), at 4:45 PM on weekdays.`

Alerts will be sent out 10-15 minutes before the scheduled arrival time of the bus each day. An alert might look like:

`Service Alert for HSR Bus Stop 1145 (MAIN AT EMERSON), Route 51 (UNIVERSITY, EASTBOUND), scheduled for 4:45 PM: Bus is running 3 mins late. ETA is 4:48 PM.`

If the expected arrival time of the bus changes between the first alert and the forecasted arrival time, another alert will be sent to the rider within a few minutes of the arrival time.

## How it Works

The service Twilio is used to act as a "middle man" between the service and the user. The service sends messages to the Twilio service which texts the message to the user (and vice versa). The user must initiate the service with a text, upon which Twilio will provide our service with the user's phone number and message.

When a rider sends a text to the service, the message is parsed and relevant data is extracted. Messages sent can be in plain english with the serivce doing the heavy lifting to parse what is being requested.

## Costs

Twilio charges a small fee per text message and can using short code messaging (messages send from a five or six-digit number) send up to 30 messages per second, or 1800 messages per minute; well over the expected requirements for the HSR service. Each message can contain up to 1600 characters; well over the expected length needed.

There is a fixed monthly cost of $3,000 per short code number, plus usage costs of $0.01 per message sent and $0.005 per message received. On this basis, a rider using two alerts per day, five days a week will cost $2.30 per month.

## Current Status

Due to the limited time, this repo has been more of a practice and exploration into the possibilities of a project like this instead of a full featured application.

The state of this application has the ability to receive and parse incoming messages requesting subscriptions to alerts. If required information is missing, a response is returned requesting the missing information. On a successful request, a confirmation of the subscription is returned.

At this point, no subscriptions actually activate.
