import express from "express";
import QRCodeController from "../../../controllers/QRCodeController.js";
import validateCreateQRCodeRequest from "../../../middlewares/ValidateCreateQRCodeRequest.js";
import validateUpdateQRCodeRequest from "../../../middlewares/ValidateUpdateQRCodeRequest.js";
import validateDeleteQRCodeRequest from "../../../middlewares/ValidateDeleteQRCodeRequest.js";


const router = express.Router();

router.route("/")
    .get(QRCodeController.getAllQRCode)
    .post([validateCreateQRCodeRequest], QRCodeController.createOneQRCode);

router.route("/:QRCodeId")
    .get(QRCodeController.getOneQRCode)
    .put([validateUpdateQRCodeRequest], QRCodeController.updateQRCode)
    .delete([validateDeleteQRCodeRequest], QRCodeController.deleteQRCode);

export default router;
