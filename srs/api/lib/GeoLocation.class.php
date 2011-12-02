<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GeoLocation
 *
 * @author Zac
 */
class GeoLocation {
    
    // Distance is assumed to be in meters
    public function getRange($distance, $long, $lat)
    {
        // Convert the degree coordinates into radians
        $long_in_rad = (180/pi());
        $lat_in_rad = (180/pi());
        
        // Radius of the earth in meters
        $radius_of_earth = 6378100;
        
        // Set up of equation components
        $a = sin(($distance/(2 * $radius_of_earth)))^2;
        $b = cos($lat)^2;
        
        // Calculate minimum and maximum ranges in Radians
        $max_longitude_rad = 2 * cos(sqrt($a/$b));
        $min_longitude_rad = $long_in_rad - $max_longitude_rad;
        $max_latitude_rad = ($distance / $radius_of_earth) + $lat_in_rad;
        $min_latitude_rad = $lat_in_rad - $max_latitude_rad;
        
        // Convert minimum and maximum ranges to degrees
        $max_latitude_degree = $max_latitude_rad * (pi()/180);
        $min_latitude_degree = $min_latitude_rad * (pi()/180);
        $max_longitude_degree = $max_longitude_rad * (pi()/180);
        $min_longitude_degree = $max_longitude_rad * (pi()/180);
        
        $ranges = array();
        $ranges[] = $max_longitude_degree;
        $ranges[] = $max_latitude_degree;
        $ranges[] = $min_longitude_degree;
        $ranges[] = $min_latitude_degree;
        
        // Returns as [Max longitude Coordinate, Max latitude Coordinate, Min longitude Coordinate, Min latitude Coordinate]
        
        return $ranges;
    }
    
}

?>
