const fileInput = document.getElementById("profileImage");
const fileMessage = document.getElementById("fileMessage");

fileInput.addEventListener("change", function () {
	const totalFiles = this.files.length;

	if (totalFiles === 0) {
		fileMessage.textContent = "PNG, JPG, GIF supported";
	} else if (totalFiles === 1) {
		fileMessage.textContent = "1 image selected";
	} else {
		fileMessage.textContent = `${totalFiles} images selected`;
	}
});
