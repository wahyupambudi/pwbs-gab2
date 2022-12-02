// script untuk membatasi inputan number
const setNumber = (e) => {
    // alternatif bisa pakai jquery masking 
    // For key or mouse events, this property indicates the specific key or button that was pressed
    let key_code = (document) ? e.keyCode : e.which;

    // jika kode ascii 48 - 57 (0-9)
    if(key_code >= 48 && key_code <= 57 ) {
        console.log(true);
        return true;
    } 
    // jika kode ascii tidak 48 - 57 (0-9)
    else {
        console.log(false);
        return false;
    }
}