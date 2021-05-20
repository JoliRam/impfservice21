<!DOCTYPE html>
<html>
<head>
    <title>Vaccination Test</title>
</head>
<body>
<ul>
    @foreach($vaccinations as $vaccination)
        <li>{{$vaccination->date_time}} {{$vaccination->max_persons}}</li>
    @endforeach
</ul>
</body>
</html>
