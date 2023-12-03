const btn = document.querySelector('.talk');
const content = document.querySelector('.contents');


const treatment = ['Your doctors may give you an antiviral medicine called remdesivir (Veklury). Remdesivir is the first drug approved by the FDA for treatment of hospitalized COVID patients over the age of 12. Research shows that some patients recover faster after taking it. PLease click the search button for more information'];

const prevent = ['To prevent the spread of COVID-19: Maintain a safe distance from others (at least 1 metre), even if they don’t appear to be sick. Wear a mask in public, especially indoors or when physical distancing is not possible. Choose open, well-ventilated spaces over closed ones. Open a window if indoors. Clean your hands often. Use soap and water, or an alcohol-based hand rub. Get vaccinated when it’s your turn. Follow local guidance about vaccination. Cover your nose and mouth with your bent elbow or a tissue when you cough or sneeze. Stay home if you feel unwell. PLease click the search button for more information'];

const risk = ['The risk of developing dangerous symptoms of COVID-19 may be increased in people who are older and also in people of any age who have other serious health problems — such as heart or lung conditions, weakened immune systems, obesity, or diabetes. This is similar to what is seen with other respiratory illnesses, such as influenza. PLease click the search button for more information'];

const symptoms = ['Most common symptoms: fever cough tiredness loss of taste or smell Less common symptoms: sore throat headache aches and pains diarrhoea a rash on skin, or discolouration of fingers or toes red or irritated eyes Serious symptoms: difficulty breathing or shortness of breath loss of speech or mobility, or confusion chest pain Seek immediate medical attention if you have serious symptoms. Always call before visiting your doctor or health facility. PLease click the search button for more information'];

const sideEffects = ['The possible side effects of a vaccine include pain, redness, itchiness or swelling at the injection site (which may last a few hours); fever; feeling of weakness or fatigue; headache; dizziness; diarrhea; or nausea. Consult the nearest healthcare professional if you experience any of these. PLease click the search button for more information'];

const covik = [
    'Did you mean Covik? Covik aims to counter the threats of mis-information regarding covid-19, vaccines, health protocols in addition to public health. PLease click the search button for more information'
];

const vaccines = [
    'A vaccine (or immunization) is a way to build your body’s natural immunity to a disease before you get sick. This keeps you from getting and spreading the disease. For most vaccines, a weakened form of the disease germ is injected into your body. This is usually done with a shot in the leg or arm. Your body detects the invading germs (antigens) and produces antibodies to fight them. Those antibodies then stay in your body for a long time. In many cases, they stay for the rest of your life. If you’re ever exposed to the disease again, your body will fight it off without you ever getting the disease. PLease click the search button for more information'
];

const covid = ['Coronavirus disease (COVID-19) is an infectious disease caused by the SARS-CoV-2 virus. Most people infected with the virus will experience mild to moderate respiratory illness and recover without requiring special treatment. However, some will become seriously ill and require medical attention. Older people and those with underlying medical conditions like cardiovascular disease, diabetes, chronic respiratory disease, or cancer are more likely to develop serious illness. PLease click the search button for more information'];

const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
const recognition = new SpeechRecognition();

recognition.onstart = function () {
    console.log('voice is activated, you can speak to the microphone');
};

recognition.onresult = function (event) {
    const current = event.resultIndex;

    const transcript = event.results[current][0].transcript;
    content.textContent = transcript;
    readOutLoud(transcript);
    content.value = transcript;
};

//add the listener to the button

btn.addEventListener('click', () => {
    recognition.start();
    const div = document.querySelector('#speech-btn');
    console.log(div.innerHTML);
    div.innerHTML = '<i class="fa fa-microphone"></i>';
});

function readOutLoud(message) {
    const speech = new SpeechSynthesisUtterance();

    speech.text = 'PLease click the search button for more information';

    if (message.includes('kovac')) {
        const finalText =
            covik[Math.floor(Math.random() * covik.length)];
        speech.text = finalText;
    }

    else if (message.includes('kobe')) {
        const finalText =
            covik[Math.floor(Math.random() * covik.length)];
        speech.text = finalText;
    }

    else if (message.includes('covid-19 information kiosk')) {
        const finalText =
            covik[Math.floor(Math.random() * covik.length)];
        speech.text = finalText;
    }

    else if (message.includes('cubic')) {
        const finalText =
            covik[Math.floor(Math.random() * covik.length)];
        speech.text = finalText;
    }

    else if (message.includes('prevent')) {
        const finalText =
            prevent[Math.floor(Math.random() * prevent.length)];
        speech.text = finalText;
    }

    else if (message.includes('risks')) {
        const finalText =
            risk[Math.floor(Math.random() * risk.length)];
        speech.text = finalText;
    }

    else if (message.includes('symptoms')) {
        const finalText =
            symptoms[Math.floor(Math.random() * symptoms.length)];
        speech.text = finalText;
    }

    else if (message.includes('side-effects')) {
        const finalText =
            sideEffects[Math.floor(Math.random() * sideEffects.length)];
        speech.text = finalText;
    }

    else if (message.includes('treatments for covid-19')) {
        const finalText =
            treatment[Math.floor(Math.random() * treatment.length)];
        speech.text = finalText;
    }

    else if (message.includes('vaccine')) {
        const finalText =
            vaccines[Math.floor(Math.random() * vaccines.length)];
        speech.text = finalText;
    }

    else if (message.includes('covid-19')) {
        const finalText =
            covid[Math.floor(Math.random() * covid.length)];
        speech.text = finalText;
    }

    speech.volume = 1;
    speech.rate = 1;
    speech.pitch = 1;

    window.speechSynthesis.speak(speech);
    btn.addEventListener("keydown", (event) => {
        const key = event.key; 
        // Cancel the speechSynthesis instance
        if(key === "Escape"){
            window.speechSynthesis.cancel();
            //document.getElementById("speech-btn").style.color = "blue";
            const div = document.querySelector('#speech-btn');
            console.log(div.innerHTML);
            div.innerHTML = '<i class="fas fa-volume-mute"></i>';
        }
        else{
            const div = document.querySelector('#speech-btn');
            console.log(div.innerHTML);
            div.innerHTML = '<i class="fa fa-microphone"></i>';
        }
    });

    btn.addEventListener("dblclick", () => {
        // Cancel the speechSynthesis instance
            window.speechSynthesis.cancel();
            const div = document.querySelector('#speech-btn');
            console.log(div.innerHTML);
            div.innerHTML = '<i class="fas fa-volume-mute"></i>';
    });
}
