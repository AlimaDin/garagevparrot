fdocument.addEventListener('DOMContentLoaded', (event) => {
    console.log("Document loaded");
    
    const sliderValues = document.querySelectorAll(".slidervalue span");
    const inputSliders = document.querySelectorAll(".field input[type='range']");

    inputSliders.forEach((inputSlider, index) => {
        inputSlider.addEventListener('input', () => {
            console.log("Slider input event triggered");
            sliderValues[index].textContent = inputSlider.value;
        });
    });
});