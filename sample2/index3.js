const increaseButton = document.getElementById("increaseButton");
const resetButton = document.getElementById("resetButton");
const decreaseButton = document.getElementById("decreaseButton");
const countLabel = document.getElementById("countLabel");
let count = 0;

increaseButton.onclick = function(){
    if(count === 50){
        alert("You reached maximum number")
    }
    else{
            count++;
    }
    countLabel.textContent = count;
}
resetButton.onclick = function(){
    count = 0;
    countLabel.textContent = count;
}
decreaseButton.onclick = function(){
    if(count <= 0){
        alert("You reached limit");
    }
    else{
        count--;
    }
    countLabel.textContent = count;
}