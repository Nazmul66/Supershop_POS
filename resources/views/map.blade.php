<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


    <input type="text" id="location">
    <input type="text" id="latitude">
    <input type="text" id="longitute">

<!-- jQuery -->
<script src="{{ asset('/public/admin/assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBea1c08sZuunusUDq6Np6qHgMdinNNT8A&libraries=places" async></script>

<script>
    $(document).ready(function(){
        var autocomple;
        var id = 'location';

        autocomple = new google.maps.places.Autocomplete(document.getElementById(id),{
            types: ['geocode']
        })
    })
</script>
    
</body>
</html>