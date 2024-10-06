const sections = document.querySelectorAll('[data-animation]');
const animationThreshold = 100; // Adjust the visibility trigger point (in pixels)

window.addEventListener('scroll', () => {
  const scrollPosition = window.scrollY;

  sections.forEach(section => {
    const sectionTop = section.getBoundingClientRect().top;

    if (scrollPosition + animationThreshold > sectionTop) {
      section.classList.add('is-visible');
    } else {
      section.classList.remove('is-visible');
    }
  });
});


const prinval = document.getElementById('prin');    
const intval = document.getElementById('int');
const nomval = document.getElementById('nom');
const dateval=document.getElementById('date');

const subm=document.getElementById('submit');

const iaval=document.getElementById('out1');
const dueval=document.getElementById('out2');
const inputElement = document.getElementById('out3');

function incrementMonth(dateString) {
  const [year, month, day] = dateString.split('-');
  let newMonth = parseInt(month, 10) + 1;
  let newYear = year;

  if (newMonth > 12) {
    newMonth = 1;
    newYear = parseInt(year, 10) + 1;
  }

  newMonth = newMonth.toString().padStart(2, '0');

  return `${day}-${newMonth}-${newYear}`;
}
function fun1() {
    const prinValue = Number(prinval.value);
    const intVal = Number(intval.value);
    const nomVal = Number(nomval.value);
  
    if (isNaN(prinValue) || isNaN(intVal) || isNaN(nomVal)) {
      console.error("Invalid input: Please enter numbers");
      return;
    }
  
    const iavalValue = prinValue * (intVal / 100) * nomVal;
    iaval.textContent = iavalValue;
  
    const dueVal = (prinValue + iavalValue) / nomVal;
    dueval.textContent = dueVal;
    

    const currentDate = dateval.value;
    const newDate = incrementMonth(currentDate);
    for(let i=1;i<nomVal;i++){
    inputElement.innerHTML = 'The first instalment of Rs '+dueVal+ ' is due on ' +newDate;
    }
  }
  
  

subm.addEventListener('click',fun1);