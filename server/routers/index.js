import express from "express";
import controller from "../controllers/cont.js";
const router = express.Router();

router.get("/", (req, res) => {
    res.send("server aktif");
});

router.post("/send-message", controller.kirimPesan);

export default router;
