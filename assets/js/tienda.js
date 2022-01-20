$(document).ready(function () {

  // $('#precio').mask('000.000.000.000.000', { reverse: true });
  //$('#telefono').mask('(000) 000 0000', { reverse: false });  


  // $("#submit_producto").click(function (e) {
  //   $('#precio').unmask();
  //   $("#form_producto").submit(); // jQuey's submit function applied on form.
  // });

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });


  $('#exampleModalCenter').modal('show');

  /**
   * ======================================
   */

  // Verifica si el carrito esta vacio
  if ($("#contador").attr("count") == 0) {
    // Inactiva el boton
    $("#btn-carrito").toggleClass("disabled");
    $("#btn-carrito").attr("aria-disabled", "true");
    $("#contador").text("0");
  }
  else {
    // Activa el boton
    $("#btn-carrito").toggleClass("enable");
    $("#btn-carrito").attr("aria-disabled", "false");
  }

  // Get the navbar
  if (document.getElementById("categorias") !== null) {
    // When the user scrolls the page, execute myFunction
    window.onscroll = function () { myFunction() };
    var navbar = document.getElementById("categorias");

    // Get the offset position of the navbar
    var sticky = navbar.offsetTop;
    // Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
    function myFunction() {
      if (window.pageYOffset >= sticky) {
        navbar.classList.add("sticky")
      } else {
        navbar.classList.remove("sticky");
      }
    }
  }

  // $('#imagen').filer({
  //   limit: 1,
  //   maxSize: 5,
  //   extensions: ["jpg", "png", "jpeg"],
  //   appendTo: '#imageresult',
  //   changeInput: '\
  //   <div class="jFiler-input-dragDrop">\
  //     <div class="jFiler-input-inner">\
  //       <div class="jFiler-input-icon">\
  //         <i class="icon-jfi-cloud-up-o"></i>\
  //       </div>\
  //       <div class="jFiler-input-text">\
  //         <h3>Arrastra y suelta la foto aquí</h3>\
  //         <span style="display:inline-block; margin: 15px 0">o</span>\
  //       </div>\
  //       <a class="jFiler-input-choose-btn blue">Seleccionar archivo</a>\
  //     </div>\
  //   </div>',
  //   showThumbs: true,
  //   templates: {
  //     box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
  //     item: '<li class="jFiler-item">\
	// 					<div class="jFiler-item-container">\
	// 						<div class="jFiler-item-inner">\
	// 							<div class="jFiler-item-thumb">\
	// 								<div class="jFiler-item-status"></div>\
	// 								<div class="jFiler-item-thumb-overlay">\
	// 									<div class="jFiler-item-info">\
	// 										<div style="display:table-cell;vertical-align: middle;">\
	// 											<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
	// 											<span class="jFiler-item-others">{{fi-size2}}</span>\
	// 										</div>\
	// 									</div>\
	// 								</div>\
	// 								{{fi-image}}\
	// 							</div>\
	// 							<div class="jFiler-item-assets jFiler-row">\
	// 								<ul class="list-inline pull-left">\
	// 									<li>{{fi-progressBar}}</li>\
	// 								</ul>\
	// 								<ul class="list-inline pull-right">\
	// 									<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
	// 								</ul>\
	// 							</div>\
	// 						</div>\
	// 					</div>\
	// 				</li>',
  //     itemAppend: '<li class="jFiler-item">\
	// 						<div class="jFiler-item-container">\
	// 							<div class="jFiler-item-inner">\
	// 								<div class="jFiler-item-thumb">\
	// 									<div class="jFiler-item-status"></div>\
	// 									<div class="jFiler-item-thumb-overlay">\
	// 										<div class="jFiler-item-info">\
	// 											<div style="display:table-cell;vertical-align: middle;">\
	// 												<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
	// 												<span class="jFiler-item-others">{{fi-size2}}</span>\
	// 											</div>\
	// 										</div>\
	// 									</div>\
	// 									{{fi-image}}\
	// 								</div>\
	// 								<div class="jFiler-item-assets jFiler-row">\
	// 									<ul class="list-inline pull-left">\
	// 										<li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
	// 									</ul>\
	// 									<ul class="list-inline pull-right">\
	// 										<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
	// 									</ul>\
	// 								</div>\
	// 							</div>\
	// 						</div>\
	// 					</li>',
  //     progressBar: '<div class="bar"></div>',
  //     itemAppendToEnd: true,
  //     canvasImage: true,
  //     removeConfirmation: true,
  //     _selectors: {
  //       list: '.jFiler-items-list',
  //       item: '.jFiler-item',
  //       progressBar: '.bar',
  //       remove: '.jFiler-item-trash-action'
  //     },
  //     dragDrop: {
  //       dragEnter: null,
  //       dragLeave: null,
  //       drop: null,
  //       dragContainer: null,
  //     },
  //     captions: {
  //       button: "Selecciona la imagen",
  //       feedback: "Selecciona las imagenes  para subir",
  //       feedback2: "las imagenes fueron elegidas",
  //       drop: "Suelta aquí para subir",
  //       removeConfirmation: "¿Estás seguro de que quieres eliminar este archivo?",
  //       errors: {
  //         filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
  //         filesType: "Only Images are allowed to be uploaded.",
  //         filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
  //         filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
  //       }
  //     }
  //   }
  // });

});