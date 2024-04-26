import express from "express";
import user from "./Users.js";
import auth from "./Auth.js";
import verifyToken from "../../../middlewares/VerifyToken.js";
import checkUserIsAuthentic from "../../../middlewares/CheckUserIsAuthentic.js";
import familyGroup from "./FamilyGroup.js";
import checkUIDIsCorrect from "../../../middlewares/CheckUIDIsCorrect.js";
import QRCode from "./QRCode.js";
import QRCodeController from "../../../controllers/QRCodeController.js";

const router = express.Router();

router.get("/", function (req, res) {
  res.send("API version 0 works!");
});

router.use("/auth", auth);
router.use("/user/:uid", [verifyToken, checkUserIsAuthentic, checkUIDIsCorrect], user);
router.use("/user/:uid/family-group", [verifyToken, checkUserIsAuthentic, checkUIDIsCorrect], familyGroup);
router.use("/user/:uid/qr-code", [verifyToken, checkUserIsAuthentic, checkUIDIsCorrect], QRCode);
router.use("/qr-code/:QRCodeHash", QRCodeController.show);

export default router;
