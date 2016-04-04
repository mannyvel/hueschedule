# hueschedule

This project is simple: it sets the schedules of the hue alarms containing the word "Porch" to 10 minutes after sundown.

This uses the AlphaHue php library.

Run it every day, and your lights will automagically schedule themselves.

Oh, you have to add this to the AlphaHue class:

    
    public function updateScheduleTime($schedule_id, $time)
    {
        $this->throttle();
        $response = $this->rest->put("schedules/{$schedule_id}", "{\"localtime\" : \"$time\"}");
        return $response;
    }

