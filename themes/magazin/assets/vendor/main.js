$( document ).ready(function() {
    $('.product_images').magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery:{enabled:true}
    });
});