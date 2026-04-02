import wa from "../wa.js";

// Helper to handle response for send message
const handleResponSendMessage = (result, res, errorMsg = null) => {
    if (result) return res.send({ status: true, data: result });
    return res.send({
        status: false,
        message: errorMsg ?? "Check your parameter",
    });
};

// kirimPesan
const kirimPesan = async (req, res) => {
    const { token, number, message, filename } = req.body;
    if (token && number && message) {
        const result = await wa.sendMessage(token, number, message);
        console.log("Result kirimPesan: ", result);
        return handleResponSendMessage(result, res);
    }
    res.send({
        status: false,
        message: "Check your parameter",
    });
};

export default { kirimPesan };
