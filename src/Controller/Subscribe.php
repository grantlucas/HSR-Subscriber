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
}
