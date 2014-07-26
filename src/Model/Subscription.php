<?php

Namespace Model;

class Subscription extends Model
{
    protected $id        = null;
    protected $created   = null;
    public $phone        = null;
    public $route        = null;
    public $stop         = null;
    public $arrival_time = null;
    public $day          = null;

    public function __construct()
    {
        // Construct parent to open DB connection
        parent::__construct();
    }

    public function save()
    {
        // Ensure required data is set before saving
        if(is_null($this->phone))
            throw new \BadMethodCallException("Phone Number must be set to save a Subscription.");

        if(is_null($this->route))
            throw new \BadMethodCallException("Route Number must be set to save a Subscription.");

        if(is_null($this->stop))
            throw new \BadMethodCallException("Stop Number must be set to save a Subscription.");

        if(is_null($this->arrival_time))
            throw new \BadMethodCallException("Time must be set to save a Subscription.");

        if(is_null($this->day))
            throw new \BadMethodCallException("Day must be set to save a Subscription.");

        if(is_null($this->id))
        {
            // Save a new subscription
            $query = self::$db->prepare("INSERT INTO subscription (phone_number, stop_number, bus_route, arrival_time, day_of_week, created) VALUES(:phone_number, :stop_number, :bus_route, :arrival_time, :day_of_week, :created)");

            $current_time = time();

            $data = array(
                ":phone_number" => $this->phone,
                ":stop_number"  => $this->stop,
                ":bus_route"    => $this->route,
                ":arrival_time" => $this->arrival_time,
                ":day_of_week"  => $this->day,
                ":created"      => $current_time,
            );
            // Execute query
            $result = $query->execute($data);

            if($result)
            {
                // Set the ID to the generated ID
                $this->id = self::$db->lastInsertId();
            }
            else
            {
                // Insert failed
                throw new \Exception("Subscription creation failed.");
            }
        } else {
            //TODO: update an existing subscription
        }
    }
}
