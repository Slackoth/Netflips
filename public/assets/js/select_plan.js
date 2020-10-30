const cardList = [];

function setCardOnClick() {
    var cards = $(".card");
    $.each(cards, (index, element) => { 
        $(`#${element.id}`).click(function (e) { 
            $(this).css("border-color", "blue");
            
            if(cardList.length == 0) 
                cardList.push($(this));
            else {
                cardList[0].attr("id") == $(this).attr("id") ? 
                    true : cardList[0].css("border-color", "");
                cardList.pop();
                cardList.push($(this));
            }
        });
    });
}

setCardOnClick();

$("#next_btn").click(function (e) { 
    var cardId = cardList[0] == undefined ? "card_1" : cardList[0].attr("id");
    var small = $(`#${cardId}`).find("small");
    var typeId = small.attr("id");
    $.ajax({
        type: "post",
        url: `${window.location.origin}/selectplan`,
        data: {
            "type": typeId
        },
        dataType: "text",
        success: function (response) {
            console.log(response);
        }
    }).fail(( jqXHR, textStatus, errorThrown) => {
        alert(errorThrown);
    });
});
