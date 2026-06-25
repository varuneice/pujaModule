<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

$userData = $tpl['userData'] ?? array();
$registrationId = $tpl['id'] ?? ($userData['id'] ?? '');
$memberName = trim(($userData['First_name'] ?? '') . ' ' . ($userData['Last_name'] ?? ''));
$pujaType = $userData['puja_type'] ?? '';
$memberEmail = $userData['email'] ?? '';
$memberPhone = $userData['phone'] ?? ($userData['alternatenumber'] ?? '');
?>
<style>
    .document-upload-page {
        min-height: 60vh;
        padding: 24px 15px;
        background: #f5f7f9;
    }
    .document-upload-panel {
        max-width: 920px;
        margin: 0 auto;
        background: #fff;
        border: 1px solid #d9e0e6;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .document-upload-logo {
        text-align: center;
        margin-bottom: 20px;
    }
    .document-upload-logo img {
        width: 170px;
        max-width: 100%;
    }
    .document-upload-title {
        font-size: 28px;
        text-align: center;
        margin: 12px 0 24px;
        font-family: Georgia, serif;
    }
    .document-upload-details {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .document-upload-details td {
        padding: 10px;
        border: 1px solid #ddd;
        vertical-align: top;
    }
    .document-upload-error {
        display: none;
        color: #d71920;
        font-weight: bold;
        margin-top: 8px;
    }
    .document-upload-preview {
        display: none;
        margin-top: 10px;
    }
    .document-upload-preview img {
        display: none;
        max-width: 280px;
        max-height: 190px;
        border: 1px solid #ccc;
        padding: 4px;
    }
    .document-upload-preview span {
        display: none;
        font-size: 13px;
        color: #333;
    }
</style>

<section class="document-upload-page">
    <div class="document-upload-panel">
        <div class="document-upload-logo">
            <img src="<?php echo INSTALL_URL; ?>HDBS_Logo_HiRes.png" alt="HDBS Logo">
        </div>
        <div class="document-upload-title">HDBS Puja Registration System</div>

        <form id="new-document-upload-form" class="frm-class user-frm-class"
            action="<?php echo INSTALL_URL; ?>PujaOnlinePayments/userNewDocumentUpload" method="post"
            enctype="multipart/form-data">
            <table class="document-upload-details">
                <tr>
                    <td colspan="2"><strong>Upload New Document</strong></td>
                </tr>
                <tr>
                    <td>
                        <strong>Puja Type:</strong>
                        <?php echo htmlspecialchars((string) $pujaType, ENT_QUOTES); ?>
                        <input type="hidden" name="pujaType" value="<?php echo htmlspecialchars((string) $pujaType, ENT_QUOTES); ?>">
                    </td>
                    <td>
                        <strong>Member Name:</strong>
                        <?php echo htmlspecialchars((string) $memberName, ENT_QUOTES); ?>
                        <input type="hidden" name="memberName" value="<?php echo htmlspecialchars((string) $memberName, ENT_QUOTES); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Email:</strong>
                        <?php echo htmlspecialchars((string) $memberEmail, ENT_QUOTES); ?>
                        <input type="hidden" name="memberEmail" value="<?php echo htmlspecialchars((string) $memberEmail, ENT_QUOTES); ?>">
                    </td>
                    <td>
                        <strong>Phone:</strong>
                        <?php echo htmlspecialchars((string) $memberPhone, ENT_QUOTES); ?>
                        <input type="hidden" name="memberPhone" value="<?php echo htmlspecialchars((string) $memberPhone, ENT_QUOTES); ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label for="file"><strong>Upload document</strong></label>
                        <input required class="form-control" type="file" name="image" id="file"
                            accept=".jpg,.jpeg,.png,.pdf" onchange="validateDocumentUpload(this)">
                        <p class="help-block">
                            Upload document (Student ID or Out of Towner Address Verification as applicable).
                            Allowed formats: jpg, jpeg, png, pdf. Maximum size: 8 MB.
                        </p>
                        <div id="documentUploadError" class="document-upload-error"></div>
                        <div id="documentPreview" class="document-upload-preview">
                            <img id="documentPreviewImage" src="" alt="Document preview">
                            <span id="documentPreviewPdf"></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="uploadNewDocument" value="1">
                        <input type="hidden" name="userId" value="<?php echo htmlspecialchars((string) $registrationId, ENT_QUOTES); ?>">
                        <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>"
                            name="submit" type="submit">
                            <i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?>
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</section>

<script>
    var documentUploadValid = false;

    function setDocumentUploadError(message) {
        documentUploadValid = false;
        $("#documentUploadError").text("Upload failed: " + message).show();
        $("#documentPreview").hide();
        $("#documentPreviewImage").hide().attr("src", "");
        $("#documentPreviewPdf").hide().text("");
        $("#file").val("");
    }

    function clearDocumentUploadError() {
        documentUploadValid = true;
        $("#documentUploadError").hide().text("");
    }

    function validateDocumentUpload(input) {
        clearDocumentUploadError();
        $("#documentPreview").hide();
        $("#documentPreviewImage").hide().attr("src", "");
        $("#documentPreviewPdf").hide().text("");

        if (!input.files || !input.files[0]) {
            documentUploadValid = false;
            return true;
        }

        var file = input.files[0];
        var fileName = file.name.toLowerCase();
        var allowed = /\.(jpg|jpeg|png|pdf)$/i.test(fileName);
        var maxSize = 8 * 1024 * 1024;

        if (!allowed) {
            setDocumentUploadError("only jpg, jpeg, png, or pdf files are allowed.");
            return false;
        }

        if (file.size > maxSize) {
            setDocumentUploadError("file size must be 8 MB or less.");
            return false;
        }

        if (fileName.endsWith(".pdf")) {
            documentUploadValid = true;
            $("#documentPreview").show();
            $("#documentPreviewPdf").text("Selected PDF: " + file.name).show();
            return true;
        }

        documentUploadValid = false;
        var reader = new FileReader();
        reader.onload = function (event) {
            var img = new Image();
            img.onload = function () {
                if (img.width < 800 || img.height < 500) {
                    setDocumentUploadError("document image is too small or not clear enough. Please upload a clearer document.");
                    return;
                }

                var aspectRatio = img.width / Math.max(1, img.height);
                if (aspectRatio < 0.45 || aspectRatio > 3.2) {
                    setDocumentUploadError("document image is not framed clearly. Please upload the full document.");
                    return;
                }

                var canvas = document.createElement("canvas");
                var sampleWidth = Math.min(120, img.width);
                var sampleHeight = Math.max(1, Math.round(sampleWidth * img.height / img.width));
                canvas.width = sampleWidth;
                canvas.height = sampleHeight;
                var ctx = canvas.getContext("2d");
                if (ctx) {
                    ctx.drawImage(img, 0, 0, sampleWidth, sampleHeight);
                    var pixels = ctx.getImageData(0, 0, sampleWidth, sampleHeight).data;
                    var count = 0;
                    var sum = 0;
                    var sumSquares = 0;

                    for (var i = 0; i < pixels.length; i += 16) {
                        var gray = (0.299 * pixels[i]) + (0.587 * pixels[i + 1]) + (0.114 * pixels[i + 2]);
                        sum += gray;
                        sumSquares += gray * gray;
                        count++;
                    }

                    var average = sum / Math.max(1, count);
                    var variance = Math.max(0, (sumSquares / Math.max(1, count)) - (average * average));
                    var contrast = Math.sqrt(variance);

                    if (average < 45) {
                        setDocumentUploadError("document image is too dark. Please upload a clearer document.");
                        return;
                    }

                    if (average > 235) {
                        setDocumentUploadError("document image is too light or washed out. Please upload a clearer document.");
                        return;
                    }

                    if (contrast < 18) {
                        setDocumentUploadError("document image has low contrast and may not be legible. Please upload a clearer document.");
                        return;
                    }
                }

                documentUploadValid = true;
                $("#documentPreview").show();
                $("#documentPreviewImage").attr("src", event.target.result).show();
            };
            img.onerror = function () {
                setDocumentUploadError("document image could not be read.");
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);

        return true;
    }

    $("#new-document-upload-form").on("submit", function () {
        if (!documentUploadValid) {
            setDocumentUploadError("please choose a valid document before submitting.");
            return false;
        }
        return true;
    });
</script>
