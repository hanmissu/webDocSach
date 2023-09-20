function toogle() {
    var popup = document.getElementById('popup');
    popup.classList.toggle('active');
}

function toogleProduct() {
    var popup = document.getElementById('popup_product');
    popup.classList.toggle('active');
}

function getValue(index) {
    var tenTheLoaiValue = document.getElementById('tenTheLoai' + index).value;
    var maTheLoaiValue = document.getElementById('maTheLoai' + index).value;
    document.getElementById('tenTheLoai_sua').value = tenTheLoaiValue;
    document.getElementById('maTheLoai_sua').value = maTheLoaiValue;
    document.getElementById('tenTheLoai_cu').value = tenTheLoaiValue;
}

function getPublisher(index) {
    var ten = document.getElementById('tenNSX' + index).value;
    var ma = document.getElementById('maNSX' + index).value;
    document.getElementById('tenNSX_sua').value = ten;
    document.getElementById('maNSX_sua').value = ma;
}

function selectImage(image_id, input_id) {
    const img = document.getElementById(image_id)
    const input = document.getElementById(input_id)
    input.addEventListener("change", () => {
        img.src = URL.createObjectURL(input.files[0])
    })
}