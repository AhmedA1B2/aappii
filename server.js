const express = require("express");
const app = express();
const bodyP = require("body-parser");
const compiler = require("compilex");
const path = require("path");
const options = { stats: true };

compiler.init(options);

app.use(bodyP.json());

// ⬅️ هذا يخلي كل الملفات الثابتة تشتغل (HTML, CSS, JS من مجلد public)
app.use(express.static(path.join(__dirname, "public")));

// ⬅️ نحدد ملفات HTML باستخدام المسار الصحيح
app.get("/", function (req, res) {
    res.sendFile(path.join(__dirname, "public", "login.html"));
});

app.get("/index", function (req, res) {
    res.sendFile(path.join(__dirname, "public", "index.html"));
});

// خدمة كود الكومبايل
app.post("/compile", function (req, res) {
    const code = req.body.code;
    const input = req.body.input;
    const lang = req.body.lang;

    try {
        if (lang === "CPP") {
            const envData = { OS: "windows", cmd: "g++", options: { timeout: 10000 } };
            if (!input) {
                compiler.compileCPP(envData, code, function (data) {
                    res.send(data);
                });
            } else {
                compiler.compileCPPWithInput(envData, code, input, function (data) {
                    res.send(data);
                });
            }
        } else if (lang === "Java") {
            const envData = { OS: "windows" };
            if (!input) {
                compiler.compileJava(envData, code, function (data) {
                    res.send(data);
                });
            } else {
                compiler.compileJavaWithInput(envData, code, input, function (data) {
                    res.send(data);
                });
            }
        } else if (lang === "Python") {
            const envData = { OS: "windows" };
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
