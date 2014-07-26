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
    }
}
