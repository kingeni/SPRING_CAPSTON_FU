//MQTT AREA
var mqtt = require('mqtt');
var client = mqtt.connect('mqtt://broker.mqttdashboard.com');

client.on('connect', function () {
    console.log('MQTT Connected!!!');
    client.subscribe('huy/test');
})

client.on('message', (topic, message) => {
    if (topic === 'huy/test') {
        console.log(message.toString());
        var listValue = message.toString().split(',');
        var sql = 'INSERT INTO transaction (id, vehicle_weight, unit_id, created_at, img_url, vehicle_id, station_id, status) ' +
            'VALUES ("' + listValue[0] + '", ' + listValue[1] + ', ' + listValue[2] + ', "' + listValue[3] + '", "' + listValue[4] + '", "' + listValue[5] + '", "' + listValue[6] + '", ' + listValue[7] + ')';
        con.query(sql, function (err, result) {
            if (err) throw err;
            console.log('1 record inserted');
        });

        io.emit('new_transaction', 'update transaction');
        console.log('Emit Success!!!');
    }
})

//MYSQL AREA
var mysql = require('mysql');
var con = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '123456',
    database: 'vwms'
});

con.connect(function (err) {
    if (err) throw err;
    console.log('Database Connected!!!')
});

//SOCKET.IO AREA
var socket = require('socket.io');
var http = require('http');

var http_server = http.createServer()
var io = socket.listen(http_server);
var port = 3001;

http_server.listen(port, function () {
    console.log('Server listening at', port)
})

io.on('connection', function (socket) {
    socket.on('check_connection', function (message) {
        console.log('ahuhu: ' + message);
    })
})