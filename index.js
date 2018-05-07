let static = require('node-static');

let file = new static.Server('./projectfiles/main.html');

require('http').createServer(function(req,res){
    req.addListener('end',function(){
        file.serve(req,res);
    }).resume();
}).listen(process.env.PORT|| 3000)