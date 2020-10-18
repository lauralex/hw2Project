
let selectedEl;
function modal_submit(event) {
    event.preventDefault();

    function responseHandler(res) {

        if (res.status == 422) {
            return res.json().then((jsondata)=>alert(jsondata['message']), () => Promise.reject('error'));

        }
        if (!res.ok) {
            return Promise.reject("Invalid Response");
        }
        $('#post_modal').modal('hide');
        return Promise.resolve('Post Published!');
    }



    const content_uri = encodeURIComponent(selectedEl.querySelector('img').src);
    const content_title = encodeURIComponent(event.currentTarget['title'].value.trim());
    if (content_title == "") {
        alert ("Inserire titolo");
        return;
    }
    const yt_url = selectedEl.href == "javascript:void(0);" ? "" : selectedEl.href;

    const options = {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams(`uri=${content_uri}&title=${content_title}&yt_url=${yt_url}`)
    }

    fetch(create_post_url, options).then(responseHandler).then((message)=>alert(message)).catch((reason) => alert(reason));

}

function selectedElement(event) {
    event.preventDefault();
    $('#post_modal').modal('show');
    selectedEl = event.currentTarget;
}

function doSomething(info) {
    const flexContainer = document.body.querySelector("#result_list");
    const column = document.createElement('div');
    column.classList.add("col-sm", "mb-4");
    column.style.minWidth = 'initial';

    const card = document.createElement('div');
    card.classList.add("card");

    const image = document.createElement('img');
    image.classList.add("card-img-top");
    image.src = info['coverImage']['extraLarge'];

    //image.addEventListener("click", selectedElement);

    const clickableImage = document.createElement("a");
    clickableImage.href = "javascript:void(0);";
    clickableImage.addEventListener("click", selectedElement);

    const cardBody = document.createElement('div');
    cardBody.classList.add("card-body")

    const cardTitle = document.createElement('h5');
    cardTitle.classList.add("card-title");
    cardTitle.textContent = info['title']['romaji'];

    flexContainer.append(column);
    column.append(card);
    card.append(clickableImage, cardBody);
    clickableImage.append(image);
    cardBody.append(cardTitle);
    flexContainer.classList.remove("d-none");
}

function yt_routine(info, item) {
    const flexContainer = document.body.querySelector("#result_list");
    const column = document.createElement('div');
    column.classList.add("col-sm", "mb-4");
    column.style.minWidth = 'initial';

    const card = document.createElement('div');
    card.classList.add("card");

    const image = document.createElement('img');
    image.classList.add("card-img-top");
    image.src = info['thumbnails']['high']['url'];
    //image.addEventListener("click", selectedElement);

    const clickableImage = document.createElement("a");
    clickableImage.href = `http://youtube.com/watch?v=${item['id']['videoId']}`;
    clickableImage.addEventListener("click", selectedElement);

    const cardBody = document.createElement('div');
    cardBody.classList.add("card-body")

    const cardTitle = document.createElement('h5');
    cardTitle.classList.add("card-title");
    cardTitle.textContent = info['title'];

    flexContainer.append(column);
    column.append(card);
    card.append(clickableImage, cardBody);
    clickableImage.append(image);
    cardBody.append(cardTitle);
    flexContainer.classList.remove("d-none");
}

function submitHandler(event) {
    event.preventDefault();
    if (document.body.querySelector("#result_list div")) {
        document.body.querySelector("#result_list").innerHTML = "";
    }
    async function responseHandler(response) {


        if (response.status == 422) {
            return response.json().then((errors) => Promise.reject(errors['message']), () => Promise.reject('error'));
        }
        if (!response.ok) {
            return Promise.reject();
        }
        return response.text();
    }

    function jsonHandler(textRes) {
        let infos = null;

        if (search_form.elements['service_select'].value == 'AniList') {

            try {
                infos = JSON.parse(textRes)['data']['Page']['media'];
            } catch (e) {
                alert("Request error, retry! -- " + e.message);
                return;
            }
            for (const info in infos) {
                doSomething(infos[info]);
            }
        } else {
            const items = JSON.parse(textRes)['items'];
            //console.log(items);
            for (const item in items) {

                yt_routine(items[item]['snippet'], items[item]);
            }
        }
    }



    const form_data = new FormData(search_form);
    //console.log(form_data);
    const options = {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: form_data
    }
    $('input').blur();
    fetch(uri, options).then(responseHandler).then(jsonHandler).catch((error) => alert(error));
}

const search_form = document.forms['search_form'];

search_form.addEventListener('submit', submitHandler);
document.forms['modal_form'].addEventListener("submit", modal_submit);
