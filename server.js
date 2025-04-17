const express = require("express");
const bodyP = require("body-parser");
const compiler = require("compilex");
const axios = require("axios");
const path = require("path");

const app = express();
const options = { stats: true };
compiler.init(options);

app.use(bodyP.json());
app.use(bodyP.urlencoded({ extended: true }));

// ⬅️ تعديل مهم: تحديد المسار بشكل نسبي
app.use("/codemirror-5.65.18", express.static(path.join(__dirname, "codemirror-5.65.18")));
app.use(express.static(__dirname)); // للسماح بتحميل login.html وغيره

app.get("/", (req, res) => {
    res.sendFile(path.join(__dirname, "login.html"));
});

app.get("/index", (req, res) => {
    res.sendFile(path.join(__dirname, "index.html"));
});

// ✅ Proxy لحل مشكلة CORS
const https = require("https"); // أضف هذا في أعلى الملف إن لم يكن موجودًا

const axios = require("axios");
const tough = require("tough-cookie");
const { wrapper } = require("axios-cookiejar-support");

const jar = new tough.CookieJar();
const client = wrapper(axios.create({ jar }));

app.post("/proxy-login", async (req, res) => {
  try {
    // 🔐 الخطوة الأولى: الحصول على الـ cookie من السيرفر
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

    // ✅ إرسال الاستجابة للمتصفح
    res.json(response.data);
  } catch (err) {
    console.error("Proxy error:", err.message);
    res.status(500).send({ error: "Proxy error", details: err.message });
  }
});



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

app.listen(8000, () => {
    console.log("Server running on port 8000");
});
