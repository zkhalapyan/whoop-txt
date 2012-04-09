
var msglocation = new function()
{
    var type = -1;
    var position = null;
    var highAccuracy = true;
    
    //The maximum age (in milliseconds) of the reading (this is appropriate as 
    //the device may cache readings to save power and/or bandwidth).
    var timeout = 3000;
    
    //The maximum time (in milliseconds) for which you are prepared to allow 
    //the device to try to obtain a Geo location.
    var geoTimeout = 5000;
    
    this.getType = function()
    {
        if(type < 0)
            type = navigator.geolocation
                   ? 1
                   : google.gears
                     ? 2
                     : 0;
        return type;
    }

    this.getTypeName = function()
    {
        switch(this.getType())
        {
            case 1: return 'HTML5 Geolocation';
            case 2: return 'Google Gears';
            default: return 'Unsupported';
        }
    }

    this.isSupported = function()
    {
        return this.getType() > 0;
    }

    this.getPosition = function(onSuccess, onError)
    {
        var geo;
        switch(this.getType())
        {
            case 1:
                geo = navigator.geolocation;
                break;
            case 2:
                geo = google.gears.factory.create('beta.geolocation');
                break;
            default:
                mwf.touch.geolication.setError('No geolocation support available.');
                onError('No geolocation support available.');
                return;
        }

        geo.getCurrentPosition(
            function(position) {
                if(typeof onSuccess != 'undefined')
                    onSuccess({
                        'latitude':position.coords.latitude,
                        'longitude':position.coords.longitude,
                        'accuracy':position.coords.accuracy
                    });

            }, function() {
                if(typeof onError != 'undefined')
                    onError('Geolocation failure.');
            },
            {enableHighAccuracy:highAccuracy, maximumAge:timeout, timeout: geoTimeout});

        return true;
    }

    this.setTimeout = function(ms)
    {
        timeout = ms;
    }

    this.setHighAccuracy = function(bool)
    {
        highAccuracy = bool;
    }
}