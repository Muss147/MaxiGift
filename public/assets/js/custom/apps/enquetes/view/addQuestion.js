// Question number
var myModalEl = document.getElementById('kt_modal_new_question')
myModalEl.addEventListener('show.bs.modal', function (event) {
    var numero = parseInt($('.draggable-zone .draggable').length) + 1;
    $('#kt_modal_new_question input[name=numero]').val(numero);
    $('#kt_modal_new_question span.numero').text(numero);
});

// Format options
var optionFormat = function(item) {
    if ( !item.id ) {
        return item.text;
    }
    var span = document.createElement('span');
    var imgUrl = item.element.getAttribute('data-kt-select2-icon');
    var template = '';
    template += '<img src="' + imgUrl + '" class="rounded-circle h-20px me-2" alt="image"/>';
    template += item.text;

    span.innerHTML = template;
    return $(span);
}
// Init Select2 --- more info: https://select2.org/
$('#kt_docs_select2_icon').select2({
    templateSelection: optionFormat,
    templateResult: optionFormat
});

// SECTION QUESTIONS / REPONSES
function changeType(event) {
    var value = event.val();
    var reponses_div = event.parent().parent().next().find('.reponses_div');

    if (value == 'Choix Multiple') {
        reponses_div.html('<div class="input-group mb-5">'+
                '<span class="d-flex align-items-center" id="basic-addon1">'+
                    '<span class="svg-icon svg-icon-2hx">'+
                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">'+
                        '<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor"/>'+
                        '<path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor"/>'+
                        '</svg>'+
                    '</span>'+
                '</span>'+
                '<input type="text" class="form-control border-0 fs-2" name="reponses[]" placeholder="Saisissez le texte ici..." aria-label="Saisissez le texte ici..." aria-describedby="basic-addon1" required/>'+
            '</div>'+
            '<button type="button" class="btn text-primary btn-active-light-primary fs-4" onclick="addChoice($(this), 5)">'+
                '<span class="svg-icon svg-icon-primary svg-icon-2x"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">'+
                    '<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"/>'+
                    '<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"/>'+
                    '</svg>'+
                '</span> Ajouter un choix'+
            '</button>')
        ;
    }
    else if (value == 'Choix Unique') {
        reponses_div.html('<div class="input-group mb-5">'+
                '<span class="d-flex align-items-center" id="basic-addon1">'+
                    '<span class="svg-icon svg-icon-2hx">'+
                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">'+
                        '<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>'+
                        '<path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" fill="currentColor"/>'+
                        '</svg>'+
                    '</span>'+
                '</span>'+
                '<input type="text" class="form-control border-0 fs-2" name="reponses[]" placeholder="Saisissez le texte ici..." aria-label="Saisissez le texte ici..." aria-describedby="basic-addon1" required/>'+
            '</div>'+
            '<button type="button" class="btn text-primary btn-active-light-primary fs-4" onclick="addChoice($(this), 10)">'+
                '<span class="svg-icon svg-icon-primary svg-icon-2x"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">'+
                    '<rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"/>'+
                    '<rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"/>'+
                    '</svg>'+
                '</span> Ajouter un choix'+
            '</button>')
        ;
    }
    else if (value == 'Oui / Non') {
        reponses_div.html('<div class="input-group">'+
                '<span class="d-flex align-items-center" id="basic-addon1">'+
                    '<span class="svg-icon svg-icon-2hx">'+
                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">'+
                        '<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>'+
                        '<path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" fill="currentColor"/>'+
                        '</svg>'+
                    '</span>'+
                '</span>'+
                '<input type="text" class="form-control border-0 fs-2" name="reponses[]" value="Oui" placeholder="Oui" aria-label="Oui" aria-describedby="basic-addon1" readonly/>'+
            '</div>'+
            '<div class="input-group mb-5">'+
                '<span class="d-flex align-items-center" id="basic-addon1">'+
                    '<span class="svg-icon svg-icon-2hx">'+
                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">'+
                        '<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>'+
                        '</svg>'+
                    '</span>'+
                '</span>'+
                '<input type="text" class="form-control border-0 fs-2" name="reponses[]" value="Non" placeholder="Non" aria-label="Non" aria-describedby="basic-addon1" readonly/>'+
            '</div>')
        ;
    }
    else if (value == 'Note') {
        reponses_div.html('<div class="rating">'+
                '<div class="rating-label checked">'+
                    '<span class="svg-icon svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M13.0079 2.6L15.7079 7.2L21.0079 8.4C21.9079 8.6 22.3079 9.7 21.7079 10.4L18.1079 14.4L18.6079 19.8C18.7079 20.7 17.7079 21.4 16.9079 21L12.0079 18.8L7.10785 21C6.20785 21.4 5.30786 20.7 5.40786 19.8L5.90786 14.4L2.30785 10.4C1.70785 9.7 2.00786 8.6 3.00786 8.4L8.30785 7.2L11.0079 2.6C11.3079 1.8 12.5079 1.8 13.0079 2.6Z" fill="currentColor"/></svg></span>'+
                '</div>'+
                '<div class="rating-label checked">'+
                    '<span class="svg-icon svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M13.0079 2.6L15.7079 7.2L21.0079 8.4C21.9079 8.6 22.3079 9.7 21.7079 10.4L18.1079 14.4L18.6079 19.8C18.7079 20.7 17.7079 21.4 16.9079 21L12.0079 18.8L7.10785 21C6.20785 21.4 5.30786 20.7 5.40786 19.8L5.90786 14.4L2.30785 10.4C1.70785 9.7 2.00786 8.6 3.00786 8.4L8.30785 7.2L11.0079 2.6C11.3079 1.8 12.5079 1.8 13.0079 2.6Z" fill="currentColor"/></svg></span>'+
                '</div>'+
                '<div class="rating-label checked">'+
                    '<span class="svg-icon svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M13.0079 2.6L15.7079 7.2L21.0079 8.4C21.9079 8.6 22.3079 9.7 21.7079 10.4L18.1079 14.4L18.6079 19.8C18.7079 20.7 17.7079 21.4 16.9079 21L12.0079 18.8L7.10785 21C6.20785 21.4 5.30786 20.7 5.40786 19.8L5.90786 14.4L2.30785 10.4C1.70785 9.7 2.00786 8.6 3.00786 8.4L8.30785 7.2L11.0079 2.6C11.3079 1.8 12.5079 1.8 13.0079 2.6Z" fill="currentColor"/></svg></span>'+
                '</div>'+
                '<div class="rating-label">'+
                    '<span class="svg-icon svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M13.0079 2.6L15.7079 7.2L21.0079 8.4C21.9079 8.6 22.3079 9.7 21.7079 10.4L18.1079 14.4L18.6079 19.8C18.7079 20.7 17.7079 21.4 16.9079 21L12.0079 18.8L7.10785 21C6.20785 21.4 5.30786 20.7 5.40786 19.8L5.90786 14.4L2.30785 10.4C1.70785 9.7 2.00786 8.6 3.00786 8.4L8.30785 7.2L11.0079 2.6C11.3079 1.8 12.5079 1.8 13.0079 2.6Z" fill="currentColor"/></svg></span>'+
                '</div>'+
                '<div class="rating-label">'+
                    '<span class="svg-icon svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M13.0079 2.6L15.7079 7.2L21.0079 8.4C21.9079 8.6 22.3079 9.7 21.7079 10.4L18.1079 14.4L18.6079 19.8C18.7079 20.7 17.7079 21.4 16.9079 21L12.0079 18.8L7.10785 21C6.20785 21.4 5.30786 20.7 5.40786 19.8L5.90786 14.4L2.30785 10.4C1.70785 9.7 2.00786 8.6 3.00786 8.4L8.30785 7.2L11.0079 2.6C11.3079 1.8 12.5079 1.8 13.0079 2.6Z" fill="currentColor"/></svg></span>'+
                '</div>'+
            '</div>')
        ;
    }
    else if (value == 'Champ Text') {
        reponses_div.html('<div class="input-group border-bottom mb-5">'+
                '<input type="text" class="form-control border-0 fs-2" name="reponses[]" placeholder="Ici sera saisis le texte..." aria-label="Ici sera saisis le texte..." aria-describedby="basic-addon1" readonly/>'+
            '</div>')
        ;
    }
    else if (value == 'Long Text') {
        reponses_div.html('<div class="input-group border-bottom mb-5">'+
                '<textarea rows="4" class="form-control border-0 fs-2" name="reponses[]" placeholder="Ici sera saisis le texte..." aria-label="Ici sera saisis le texte..." aria-describedby="basic-addon1" readonly/></textarea>'+
            '</div>')
        ;
    }
    else if (value == 'Email') {
        reponses_div.html('<div class="input-group mb-5">'+
                '<span class="input-group-text" id="basic-addon1">'+
                    '<span class="svg-icon svg-icon-2hx">'+
                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">'+
                        '<path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="currentColor"/>'+
                        '<path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="currentColor"/>'+
                        '</svg>'+
                    '</span>'+
                '</span>'+
                '<input type="text" class="form-control fs-2" name="reponses[]" placeholder="nom@exemple.com" aria-label="nom@exemple.com" aria-describedby="basic-addon1" readonly/>'+
            '</div>')
        ;
    }
    else if (value == 'Téléphone') {
        reponses_div.html('<div class="input-group mb-5">'+
                '<span class="input-group-text" id="basic-addon1">'+
                    '<span class="svg-icon svg-icon-2hx">'+
                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">'+
                        '<path d="M6 21C6 21.6 6.4 22 7 22H17C17.6 22 18 21.6 18 21V20H6V21Z" fill="currentColor"/>'+
                        '<path opacity="0.3" d="M17 2H7C6.4 2 6 2.4 6 3V20H18V3C18 2.4 17.6 2 17 2Z" fill="currentColor"/>'+
                        '<path d="M12 4C11.4 4 11 3.6 11 3V2H13V3C13 3.6 12.6 4 12 4Z" fill="currentColor"/>'+
                        '</svg>'+
                    '</span>'+
                '</span>'+
                '<input type="text" class="form-control fs-2" name="reponses[]" placeholder="(+225) 07 070 707 07" aria-label="(+225) 07 070 707 07" aria-describedby="basic-addon1" readonly/>'+
            '</div>')
        ;
    }
    else if (value == 'Date') {
        reponses_div.html('<div class="input-group mb-5">'+
                '<span class="input-group-text" id="basic-addon1">'+
                    '<span class="svg-icon svg-icon-2hx">'+
                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">'+
                        '<path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor"/>'+
                        '<path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor"/>'+
                        '<path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor"/>'+
                        '</svg>'+
                    '</span>'+
                '</span>'+
                '<input type="text" class="form-control fs-2" name="reponses[]" placeholder="JJ / MM / AAAA" aria-label="JJ / MM / AAAA" aria-describedby="basic-addon1" readonly/>'+
            '</div>')
        ;
    }
    else if (value == 'SiteWeb') {
        reponses_div.html('<div class="input-group mb-5">'+
                '<span class="input-group-text" id="basic-addon1">'+
                    '<span class="svg-icon svg-icon-2hx">'+
                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">'+
                        '<path opacity="0.3" d="M18.4 5.59998C18.7766 5.9772 18.9881 6.48846 18.9881 7.02148C18.9881 7.55451 18.7766 8.06577 18.4 8.44299L14.843 12C14.466 12.377 13.9547 12.5887 13.4215 12.5887C12.8883 12.5887 12.377 12.377 12 12C11.623 11.623 11.4112 11.1117 11.4112 10.5785C11.4112 10.0453 11.623 9.53399 12 9.15698L15.553 5.604C15.9302 5.22741 16.4415 5.01587 16.9745 5.01587C17.5075 5.01587 18.0188 5.22741 18.396 5.604L18.4 5.59998ZM20.528 3.47205C20.0614 3.00535 19.5074 2.63503 18.8977 2.38245C18.288 2.12987 17.6344 1.99988 16.9745 1.99988C16.3145 1.99988 15.661 2.12987 15.0513 2.38245C14.4416 2.63503 13.8876 3.00535 13.421 3.47205L9.86801 7.02502C9.40136 7.49168 9.03118 8.04568 8.77863 8.6554C8.52608 9.26511 8.39609 9.91855 8.39609 10.5785C8.39609 11.2384 8.52608 11.8919 8.77863 12.5016C9.03118 13.1113 9.40136 13.6653 9.86801 14.132C10.3347 14.5986 10.8886 14.9688 11.4984 15.2213C12.1081 15.4739 12.7616 15.6039 13.4215 15.6039C14.0815 15.6039 14.7349 15.4739 15.3446 15.2213C15.9543 14.9688 16.5084 14.5986 16.975 14.132L20.528 10.579C20.9947 10.1124 21.3649 9.55844 21.6175 8.94873C21.8701 8.33902 22.0001 7.68547 22.0001 7.02551C22.0001 6.36555 21.8701 5.71201 21.6175 5.10229C21.3649 4.49258 20.9947 3.93867 20.528 3.47205Z" fill="currentColor"/>'+
                        '<path d="M14.132 9.86804C13.6421 9.37931 13.0561 8.99749 12.411 8.74695L12 9.15698C11.6234 9.53421 11.4119 10.0455 11.4119 10.5785C11.4119 11.1115 11.6234 11.6228 12 12C12.3766 12.3772 12.5881 12.8885 12.5881 13.4215C12.5881 13.9545 12.3766 14.4658 12 14.843L8.44699 18.396C8.06999 18.773 7.55868 18.9849 7.02551 18.9849C6.49235 18.9849 5.98101 18.773 5.604 18.396C5.227 18.019 5.0152 17.5077 5.0152 16.9745C5.0152 16.4413 5.227 15.93 5.604 15.553L8.74701 12.411C8.28705 11.233 8.28705 9.92498 8.74701 8.74695C8.10159 8.99737 7.5152 9.37919 7.02499 9.86804L3.47198 13.421C2.52954 14.3635 2.00009 15.6417 2.00009 16.9745C2.00009 18.3073 2.52957 19.5855 3.47202 20.528C4.41446 21.4704 5.69269 21.9999 7.02551 21.9999C8.35833 21.9999 9.63656 21.4704 10.579 20.528L14.132 16.975C14.5987 16.5084 14.9689 15.9544 15.2215 15.3447C15.4741 14.735 15.6041 14.0815 15.6041 13.4215C15.6041 12.7615 15.4741 12.108 15.2215 11.4983C14.9689 10.8886 14.5987 10.3347 14.132 9.86804Z" fill="currentColor"/>'+
                        '</svg>'+
                    '</span>'+
                '</span>'+
                '<input type="text" class="form-control fs-2" name="reponses[]" placeholder="https://" aria-label="https://" aria-describedby="basic-addon1" readonly/>'+
            '</div>')
        ;
    }
}
function addChoice(event, type) {
    var content = '<div class="input-group mb-5">'+
                    '<span class="d-flex align-items-center" id="basic-addon1">'+
                        '<span class="svg-icon svg-icon-2hx">'+
                            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">'+
                            '<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="'+type+'" fill="currentColor"/>'+
                            '</svg>'+
                        '</span>'+
                    '</span>'+
                    '<input type="text" class="form-control border-0 fs-2" name="reponses[]" placeholder="Saisissez le texte ici..." aria-label="Saisissez le texte ici..." aria-describedby="basic-addon1" required/>'+
                    '<span class="svg-icon svg-icon-danger svg-icon-2x cursor-pointer d-flex align-items-center" onclick="$(this).parent().remove()">'+
                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">'+
                            '<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>'+
                            '<rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"/>'+
                            '<rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"/>'+
                        '</svg>'+
                    '</span>'+
                '</div>';
    event.before(content);
}
