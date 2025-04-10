const express = require("express");
const app = express();
const bodyP = require("body-parser");
const compiler = require("compilex");
const path = require("path");

const options = { stats: true };
compiler.init(options);

app.use(bodyP.json());

// Serve CodeMirror static files
app.use("/codemirror-5.65.18", express.static(path.join(__dirname, "codemirror-5.65.18")));

app.get("/", function (req, res) {
    res.sendFile(path.join(__dirname, "login.html"));
});

app.get("/index", function (req, res) {
    res.sendFile(path.join(__dirname, "index.html"));
});

app.post("/compile", function (req, res) {
    var code = req.body.code;
    var input = req.body.input;
    var lang = req.body.lang;

    try {
        if (lang == "CPP") {
            var envData = { OS: "windows", cmd: "g++", options: { timeout: 10000 } };
            if (!input) {
                compiler.compileCPP(envData, code, function (data) {
                    res.send(data);
                });
            } else {
                compiler.compileCPPWithInput(envData, code, input, function (data) {
                    res.send(data);
                });
            }
        } else if (lang == "Java") {
            var envData = { OS: "windows" };
            if (!input) {
                compiler.compileJava(envData, code, function (data) {
                    res.send(data);
                });
            } else {
                compiler.compileJavaWithInput(envData, code, input, function (data) {
                    res.send(data);
                });
            }
        } else if (lang == "Python") {
            var envData = { OS: "windows" };
            if (!input) {
                compiler.compilePython(envData, code, function (data) {
                    res.send(data);
                });
            } else {
                compiler.compilePythonWithInput(envData, code, input, function (data) {
                    res.send(data);
                });
            }
        }
    } catch (e) {
        console.log("Compilation Error:", e);
        res.send({ error: "Compilation Error", details: e });
    }
});

app.listen(8000, () => {
    console.log("Server running on port 8000");
});
