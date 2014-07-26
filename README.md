# HSR-Subscriber


Subscribing to alerts and anomalies in the Hamilton Street Railway bus system

## Proposed Idea

One of the biggest priorities of transit is that it be "accessible for all". As such, on-demand data including bus arrival times, delays, and schedules should be as accessible as possible. HSR currently uses a "call-for-info" automated service, which is highly accessible, however it requires a great deal of waiting to get the desired information. To improve this issue, we propose a "text-for-info" service giving anyone with a cell phone instant access to bus info.

## Basic Functions
There are two basic functions of this service. There are of course many more possibilities for future extension of the service.

### Next Bus Info

This service allows any user waiting at an HSR bus stop to text their stop number (written on every bus stop) to an automated service. The service sends a text reply including next bus routes, destinations, and arrival times.

### Subscribe to Bus Alerts

Regular bus travellers often travel in patterns so there is an opportunity to present bus arrival info without the user having to send a prompt. When a user receives a *Next Bus Info* text for a particular stop, they have the option to reply `Subscribe`. They will then be prompted to provide details for their subscription including `Route Number`, `Scheduled Time`, and `Days of Week`.

## How it Works

The 

`subscribe to stop 1234`
