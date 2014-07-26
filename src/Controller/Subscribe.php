<?php
/**
 * Subscribe controller
 */

namespace Controller;

class Subscribe
{
    /**
     * Default subscribe action
     */
    public static function index()
    {
        $app = \Slim\Slim::getInstance();

        $view = array();

        if($app->request->post()) {
            // We've received a form submission. Validate and process
            //TODO: add check for if a subscriber is already subscribed

            $data = $app->request->post();

            echo "<xmp style='background-color: #fff;'>";
            print_r($data);
            echo "</xmp>";

            $sub               = new \Model\Subscription();
            $sub->phone        = $data['phone'];
            $sub->stop         = $data['stop'];
            $sub->route        = $data['route'];
            $sub->arrival_time = $data['arrival_time'];
            $sub->day          = $data['day'];

            try {
                $sub->save();
            } catch (\Exception $e) {
                echo "<xmp style='background-color: #fff;'>";
                print_r($e->getMessage());
                echo "</xmp>";
            } catch (\BadMethodCallException $e) {
                echo "<xmp style='background-color: #fff;'>";
                print_r($e->getMessage());
                echo "</xmp>";
            }

        }

        // Render view
        $app->render('subscriber/index.html.twig', $view);
    }

    /**
     * Update Subscribers
     *
     */
    public static function update()
    {
        $app = \Slim\Slim::getInstance();

        $twilio = new \Services_Twilio($app->user_config['twilio']['sid'],$app->user_config['twilio']['secret']);

        try {
            $message = $twilio->account->messages->sendMessage(
                $app->user_config['twilio']['number'], // From a valid Twilio number
                '2899228662', // Text this number
                "Hello monkey!"
            );
            print $message->sid;
        } catch (\Services_Twilio_RestException $e) {
            print $e->getMessage();
            print $e->getCode();

            switch ($e->getCode())
            {
                case '21610':
                    // User unsubscribed
                    //TODO: Remove this user's subscriptions from the DB
                    break;
            }

        }
    }

    /**
     * Start subscription
     */
    public static function start()
    {
        $app = \Slim\Slim::getInstance();

        $twilio = new \Services_Twilio($app->user_config['twilio']['sid'],$app->user_config['twilio']['secret']);

        // Twilio params that are sent
        // Body
        // From

        $message     = isset($_GET['Body']) ? $_GET['Body'] : null;
        //$message     = "Subscribe to stop 1234 for route 54 at 9 am monday.";
        $from_number = isset($_GET['From']) ? $_GET['From'] : null;

        if(empty($message) || empty($from_number))
            $app->halt(403);

        // Parse out the stop number from the message
        $stop_pattern = "/stop\ *([1-9]+)/i";
        $stop_matches = array();
        preg_match($stop_pattern, $message, $stop_matches);
        $stop_number = isset($stop_matches[1]) ? $stop_matches[1] : "";

        // Parse out the route number from the message
        $route_pattern = "/route\ *([1-9]+)/i";
        $route_matches = array();
        preg_match($route_pattern, $message, $route_matches);
        $route_number = isset($route_matches[1]) ? $route_matches[1] : "";

        // Parse out the time from the message
        $time_pattern = "/([1-9][0-9]?:*[0-9+]*\ *(?:am|pm))/i";
        $time_matches = array();
        preg_match($time_pattern, $message, $time_matches);
        $time = isset($time_matches[1]) ? $time_matches[1] : "";

        // Parse out the day of the week
        $day_pattern = "/(monday|tuesday|wednesday|thursday|friday|saturday|sunday|mon|tues|wed|thurs|fri|sat|sun)/i";
        $day_matches = array();
        preg_match($day_pattern, $message, $day_matches);
        $day = isset($day_matches[1]) ? $day_matches[1] : "";

        $missing_data = array();

        if($stop_number == "")
            $missing_data[] = "stop number";

        if($route_number == "")
            $missing_data[] = "route number";

        if($time == "")
            $missing_data[] = "time of day";

        if($day == "")
            $missing_data[] = "day of the week";

        if(!empty($missing_data)) {
            $response_format = "We are missing some data for your request. Please be sure to include the %s in your request.";
            $response = sprintf($response_format, implode(", ", $missing_data));

            try {
                $message = $twilio->account->messages->sendMessage(
                    $app->user_config['twilio']['number'], // From a valid Twilio number
                    $from_number, // Text this number
                    $response
                );
                print $message->sid;
            } catch (\Services_Twilio_RestException $e) {
                print $e->getMessage();
                print $e->getCode();
            }
        } else {
            // We have all the required data, send back response
            $response_format = "You are now subscribed to alerts for route %d at stop %d for arrivals around %s on %s.";
            $response = sprintf($response_format, $route_number, $stop_number, $time, $day);

            try {
                $message = $twilio->account->messages->sendMessage(
                    $app->user_config['twilio']['number'], // From a valid Twilio number
                    $from_number, // Text this number
                    $response
                );
                print $message->sid;
            } catch (\Services_Twilio_RestException $e) {
                print $e->getMessage();
                print $e->getCode();
            }
        }
    }
}
