/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

require('./components/Example');
require('./components/Pos');

require('./datatable');

$(document).ready(function() {
    $('.list-parent').change(function() {
        let controller = $(this).data('name');
        $('.list-child[controller="'+controller+'"]').prop('checked', this.checked);
    });

    $('.list-child').change(function() {
        let controller = $(this).attr('controller');
        let checked = false;
        if ($('.list-child[controller="'+controller+'"]:checked').length == $('.list-child[controller="'+controller+'"]').length) {
           checked = true;
        } else {
            checked = false;
        }

        $('.list-parent[data-name="'+controller+'"]').prop('checked', checked);
    });
});

$(document).ready(function() {
    const pathArray = window.location.pathname.split( '/' );
    const lastArr = getLastPath(pathArray);

    console.log(pathArray[1], lastArr);
    $('li.nav-item.has-treeview[menu="'+pathArray[1]+'"]').addClass('menu-open');
    $('li.nav-item.has-treeview[menu="'+pathArray[2]+'"]').addClass('menu-open');
    $('li.nav-item.has-treeview[menu="'+pathArray[1]+'"] a.nav-link.parent-menu').addClass('active');
    $('li.nav-item.has-treeview[menu="'+pathArray[2]+'"] a.nav-link.child-menu').addClass('active');
    $('li.nav-item.has-treeview[menu="'+pathArray[1]+'"] ul li.nav-item[menu="'+lastArr+'"] a').addClass('active');
    $('.nav-link[menu="'+lastArr+'"]').addClass('active').css('background-color', 'rgba(255,255,255,.1)');
});

$(function () {
  $('#logout').on('click', function() {
    Swal.fire({
      title: 'Are you sure?',
      text: "Logout this session!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, logout!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '/logout';
      }
    });
  });

  $('#btn-loading').on('click', function() {
    Swal.fire({
      title: 'Please Wait !',
      html: 'Data uploading',// add html attribute if you want or remove
      allowOutsideClick: false,
      onBeforeOpen: () => {
          Swal.showLoading()
      },
    });
  });
});

const getLastPath = (pathArray) => {
    const ignorePath = ['create', 'edit'];
    let lastArr = pathArray.pop();

    if(ignorePath.includes(lastArr) || !isNaN(lastArr)){
        lastArr = getLastPath(pathArray);
    }

    return lastArr;
}
