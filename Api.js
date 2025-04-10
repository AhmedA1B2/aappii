const express = require("express")
const app =express()
const bodyP=require("body-parser")
const compiler=require("compilex")
const options={ stats: true }

compiler.init(options)

app.use(bodyP.json())
app.use("/codemirror-5.65.18",express.static("C:/Users/MSII/Desktop/برمجيات/codemirror/codemirror-5.65.18"))
app.get("/",function(req,res){
    res.sendFile("C:/Users/MSII/Desktop/برمجيات/codemirror/login.html")
})

app.get("/index", function (req, res) {
    res.sendFile("C:/Users/MSII/Desktop/برمجيات/codemirror/index.html");
});

app.post("/compile",function(req,res){
    var code=req.body.code
    var input=req.body.input
    var lang=req.body.lang
    
    try{
        if(lang=="CPP"){
            if(!input){
                var envData = { OS : "windows" , cmd : "g++",options:{timeout:10000}};
                compiler.compileCPP(envData , code , function (data) {
                    res.send(data);
                    //data.error = error message 
                    //data.output = output value
                });
            }else{
                var envData = { OS : "windows" , cmd : "g++",options:{timeout:10000}}; 
                compiler.compileCPPWithInput(envData , code , input , function (data) {
                    res.send(data);
                });
            }
        }else if(lang=="Java"){
                if(!input){
                    var envData = { OS : "windows"}; 
                    compiler.compileJava( envData , code , function(data){
                        res.send(data);
                    });    
                }else{
                    var envData = { OS : "windows"}; 
                    compiler.compileJavaWithInput( envData , code , input ,  function(data){
                        res.send(data);
                    });
                }
                    
                
        }else if(lang=="Python"){
                if(!input){
                    var envData = { OS : "windows"}; 
                    compiler.compilePython( envData , code , function(data){
                        res.send(data);
                    });    
                }else{
                    var envData = { OS : "windows"}; 
                    compiler.compilePythonWithInput( envData , code , input ,  function(data){
                        res.send(data);        
                    });
                }
                    
                
            }
    }  
    catch(e){
        console.log("Compilation Error:", e);
        res.send({ error: "Compilation Error", details: e });
    }    
})



app.listen(8000)