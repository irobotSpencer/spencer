// let static = require('node-static');

// let file = new static.Server('./');

// require('http').createServer(function(req,res){
//     req.addListener('end',function(){
//         file.serve(req,res);
//     }).resume();
// }).listen(process.env.PORT|| 3000)

var app = require('express')();
var http = require('http').Server(app);

app.get('/', function(req, res){
    res.sendFile(/index.html);
    });

http.listen(3000, function(){
  console.log('listening on *:3000');
});