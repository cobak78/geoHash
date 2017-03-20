[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cobak78/geohash/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cobak78/geohash/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/cobak78/geohash/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/cobak78/geohash/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/cobak78/geohash/badges/build.png?b=master)](https://scrutinizer-ci.com/g/cobak78/geohash/build-status/master)
[![Code climate](https://codeclimate.com/github/cobak78/geohash)](https://codeclimate.com/github/cobak78/geohash)

# geohash

A geohash library to get some usefull data

#### Install via composer:
    composer require cobak78/geohash

#### Docker
Geohash includes a base image with test dependencies installed in.
Use docker-compose file to stand up a fpm container with the app code mounted.

#### Usage

use library to get:

    1. Distance between two geo-located points in Km, Miles and Nautic miles:
        - pass _lat, lon, lat, lon_ and _unit_ parameters to function.
        
    2. Minimum geohash precision for a given geoBound array and the number of squares you want to divide it.
        - pass an array like _[ top_left => [ lat => x, lon => y ], bottom_right => [ lat => x, lon => y ]_.
        - pass the number of squares, it has to be multiple of two.
        - Function will return the minimal geohash precision (from 1 to 12) who can contain every square.
        

    
