<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Socket</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.1/socket.io.js" integrity="sha512-Z6C1p1NIexPj5MsVUunW4pg7uMX6/TT3CUVldmjXx2kpip1eZcrAnxIusDxyFIikyM9A61zOVNgvLr/TGudOQg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    {{-- <div class="form">
        <button class="btn btn-primary" ></button>
    </div> --}}
</body>
<script>
    var socket = io.connect("https://fan2stage-live.colanapps.in");

signIn();

function signIn() {
    const eventAndUser = prompt("Enter Event Id, User_id as comma separated values");
    const values = eventAndUser.split(",");
    if (values.length < 2) {
        alert('Enter Event Id and User Id');
        return;
    }
    socket.emit('join-event', { event: values[0], user_id: values[1] });
}

socket.on('joining-confirmation', (msg) => {
    // will receive the socket idfor the user;
    console.log('My Socket Id: ', msg)
});

socket.on('live_status', (msg) => {
    console.log('live_status response: ', msg)
});

socket.on('artist_end_live', (msg) => {
    console.log('artist_end_live response: ', msg)
});

socket.on('live_fan_count', (msg) => {
    console.log('live_fan_count response: ', msg)
});

socket.on('action_graph_count', (msg) => {
    console.log('action_graph_count response: ', msg)
});

socket.on('total_action_count', (msg) => {
    console.log('total_action_count response: ', msg)
});

socket.on('artist_action_graph_count', (msg) => {
    console.log('artist_action_graph_count response: ', msg)
});
</script>
</html>