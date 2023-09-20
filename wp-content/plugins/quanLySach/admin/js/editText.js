tinymce.init({
    selector: 'textarea#textarea_add',
    plugins: [
        'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
        'table', 'emoticons', 'temlate', 'codesample'
    ],
    toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify |' +
        'bullist numlist outdent indent | link image' + 'forecolor backcolor emoticons',
    menu: {
        favs: {
            title: 'menu',
            items: 'code visualaid | searchreplace | emoticons'
        }
    },
    content_style: 'body{font-family: Helvetica, Arial, sans-serif}'
})