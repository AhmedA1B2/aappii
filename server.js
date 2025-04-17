const express = require("express");
const bodyP = require("body-parser");
const compiler = require("compilex");
const axios = require("axios");
const path = require("path");
const https = require("https");

const tough = require("tough-cookie");
const { wrapper } = require("axios-cookiejar-support");

const jar = new tough.CookieJar();
const client = wrapper(axios.create({ jar }));

const app = express();
const options = { stats: true };
compiler.init(options);

app.use(bodyP.json());
app.use(bodyP.urlencoded({ extended: true }));

// 🧱 تحميل الملفات الثابتة
app.use("/codemirror-5.65.18", express.static(path.join(__dirname, "codemirror-5.65.18")));
app.use(express.static(__dirname));

// 🏠 صفحة البداية
app.get("/", (req, res) => {
    res.sendFile(path.join(__dirname, "login.html"));
});

app.get("/index", (req, res) => {
    res.sendFile(path.join(__dirname, "index.html"));
});

// 🔐 بروكسي لتسجيل الدخول (تجاوز حماية الجافاسكربت على السيرفر)
app.post("/proxy-login", async (req, res) => {
    try {
        // 🥠 الخطوة الأولى: جلب الـ cookie الضروري من السيرفر
        await client.get("https://test-system.42web.io/s4y4mAuagw22dbw84u84y4o2/auth/login.php");

        // 📤 الخطوة الثانية: إرسال بيانات تسجيل الدخول
        const response = await client.post(
            "https://test-system.42web.io/s4y4mAuagw22dbw84u84y4o2/auth/login.php",
            new URLSearchParams(req.body).toString(),
            {
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                }
            }
        );

        res.json(response.data);
    } catch (err) {
        console.error("Proxy error:", err.message);
        res.status(500).send({ error: "Proxy error", details: err.message });
    }
});

// 🧠 تجميع الأكواد (باستخدام Compilex)
app.post("/compile", function(req, res) {
    var code = req.body.code;
    var input = req.body.input;
    var lang = req.body.lang;

    try {
        const envData = { OS: "windows", options: { timeout: 10000 } };

        if (lang === "CPP") {
            if (!input) {
                compiler.compileCPP(envData, code, data => res.send(data));
            } else {
                compiler.compileCPPWithInput(envData, code, input, data => res.send(data));
            }
        } else if (lang === "Java") {
            if (!input) {
                compiler.compileJava(envData, code, data => res.send(data));
            } else {
                compiler.compileJavaWithInput(envData, code, input, data => res.send(data));
            }
        } else if (lang === "Python") {
            if (!input) {
                compiler.compilePython(envData, code, data => res.send(data));
            } else {
                compiler.compilePythonWithInput(envData, code, input, data => res.send(data));
            }
        }
    } catch (e) {
        console.log("Compilation Error:", e);
        res.send({ error: "Compilation Error", details: e });
    }
});

// 🚀 بدء السيرفر
app.listen(8000, () => {
    console.log("Server running on port 8000");
});
