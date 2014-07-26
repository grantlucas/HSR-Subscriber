# HSR-Subscriber


Subscribing to alerts and anomalies in the Hamilton Street Railway bus system

## Proposed Idea

Knowing for certain when a bus will arrive ahead of time is a valuable service for regular transit users. Having this information can make the difference between waiting in the cold for a late bus and waiting inside until its arrival time. HSR Subscriber allows frequent transit users to receive alerts regarding the status of their bus ahead of time, allowing them to modify their routine accordingly and catch the bus.

## Basic Function

To create a transit alert for a particular stop, users will text a message to an automated number that includdes the `Stop ID`, `Route Number`, `Scheduled Time`, and `Days of Week`. The service will filter the information, create an alert, and reply back to the user with a confirmation message.

For example, a user might text `subscribe to Stop 1145, Route 51, 4:45pm, weekdays`
The automated reply would state `subscription confirmed for HSR Bus Stop 1145 (MAIN AT EMERSON), Route 51 (UNIVERSITY, EASTBOUND), at 4:45 PM on weekdays`


## How it Works

The 

`subscribe to stop 1234`
