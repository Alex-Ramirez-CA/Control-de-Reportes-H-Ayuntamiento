const dropArea = document.querySelector("#archivo");
const texto = dropArea.querySelector("h2");
const button = dropArea.querySelector(".btn-archivo");
const input = dropArea.querySelector(".input-file");
let files;

button.addEventListener("click", (e) =>{
    input.click();
});

input.addEventListener("change", (e) => {
    files = this.files;
    dropArea.classList.add("active");
    showFiles(files);
    dropArea.classList.remove("active");
});

dropArea,addEventListener("dragover", (e) => {
    e.preventDefault();
    dropArea.classList.add("active");
    texto.textContent = "Suelte el archivo para subir";
});

dropArea,addEventListener("dragleave", (e) => {
    e.preventDefault();
    dropArea.classList.remove("active");
    texto.textContent = "Seleccione o arrastre el archivo";
});

dropArea,addEventListener("drop", (e) => {
    e.preventDefault();
    files = e.dataTransfer.files;
    showFiles(files);
    dropArea.classList.remove("active");
    texto.textContent = "Archivo seleccionado";
});

function showFiles(files){
    if (files.length === undefined){
        processFile(files);
    }else{
        for (const file of files){
            processFile(file);
        }
    }
}

function processFile(file){
    const docType = file.type;
    const fileReader = new FileReader();
    const id = `file-${Math.random().toString(32).substring(7)}`;

    fileReader.addEventListener('load', e => {
        const fileUrl = fileReader.result;
        const image = `
        <div id="${id}" class="file-container">
            <img src="${fileUrl}" alt="${file.name}" width="50px">
            <div class="status">
                <span>${file.name}</span>
            </div>
        </div>
        `;
        const html = document.querySelector("#preview").innerHTML;
        document.querySelector("#preview").innerHTML = image + html;
    });

    fileReader.readAsDataURL(file);
    uploadFile(file, id);

}

function uploadFile(file){}