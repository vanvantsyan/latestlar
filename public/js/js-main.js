window.onload = function() {

  /* Mobile menu */
  (function mobileMenu() {

    var mobile = document.querySelector('.mobile-nav'),
      menu = mobile.querySelector('.nav'),
      overlay = document.querySelector('.mobile__overlay'),
      closeMenuBtn = document.querySelector('.menu-btn'),
      humb = document.querySelector('.mobile-humb');

    if (mobile) {
      showMenu();
      closeMenu();
      subMenu();
      // onScroll();
    }

    function showMenu() {
      humb.addEventListener('click', function() {
        menu.classList.toggle('mobile__menu-isOpen');
        overlay.classList.toggle('mobile__menu-isOpen');
        this.classList.toggle('close_button-js');

        document.querySelector('.mobile-header-inc').classList.toggle("fixed");
        document.querySelector('.mobile-header-inc').classList.toggle("menu_isOpen");
      })
    }

    function closeMenu() {
      overlay.addEventListener('click', function() {
        removeOpenClass()
      });
      closeMenuBtn.addEventListener('click', function(e) {
        e.preventDefault();

        removeOpenClass()
      })
    }

    function removeOpenClass() {
      overlay.classList.remove('mobile__menu-isOpen');
      menu.classList.remove('mobile__menu-isOpen');
    }

    function subMenu() {
      menu.addEventListener('click', function(e) {
        var target = e.target;
        console.log(target)


        if (target.classList.contains('submenu-btn')) {
          e.preventDefault();

          target.classList.toggle('rotate-btn')
          openSubMenu(target);
        } else {
          return;
        }

      });

      function openSubMenu(target) {
        var subMenu = target.nextElementSibling;
        console.log(subMenu.offsetHeight)
        subMenu.classList.toggle('mobile__sub-menu--isOpen')

      }
    }

    // function onScroll() {
    //     window.onscroll = function () {
    //         if(window.pageYOffset > 80) {
    //             mobile.classList.add('mobile__humb--fixed')
    //         } else {
    //             mobile.classList.remove('mobile__humb--fixed')
    //         }
    //     }
    // }
  }());

  /* Слайдеры без определенного размера и количества фотографий. У элемента обязательно должна быть ширина, поэтому рассчитываем диначически */
  let sliderPart = document.querySelectorAll('.js_slider-part');
  if (sliderPart.length > 0) {
    for (var i = sliderPart.length - 1; i >= 0; i--) {
      let sliderItem = sliderPart[i].querySelectorAll('.js_slide');
      for (var j = sliderItem.length - 1; j >= 0; j--) {
        let width = getComputedStyle(sliderItem[j].querySelector('img')).width;
        sliderItem[j].style.width = width;
      }
    }
  }


  /* SLIDER for mobile*/

  let windowWidth = document.documentElement.clientWidth;
  let percentage = document.querySelectorAll('.js_percentage');

  if (percentage.length > 0 && windowWidth < 768) {
    for (var i = percentage.length - 1; i >= 0; i--) {
      lory(percentage[i], {
        infinite: 1
      });
    }
  }
  let bestoffer = document.querySelector('.js_bestoffer');
  if (bestoffer) {
    lory(bestoffer, {
      infinite: 4
    });
  }

  let sliderStrater = document.querySelectorAll('.js_slider-starter');
  if (sliderStrater.length > 0) {
    for (var i = sliderStrater.length - 1; i >= 0; i--) {
      lory(sliderStrater[i], {
        infinite: 3
      });
    }
  }

  let sliderStraterR = document.querySelectorAll('.js_slider-starter-revenu');
  if (sliderStraterR.length > 0) {
    for (var i = sliderStraterR.length - 1; i >= 0; i--) {
      lory(sliderStraterR[i], {
        rewind: true
      });
    }
  }

  let sliderStraterP = document.querySelectorAll('.js_slider-starter_p');
  if (sliderStraterP.length > 0) {
    for (var i = sliderStraterP.length - 1; i >= 0; i--) {
      lory(sliderStraterP[i], {
        infinite: 6
      });
    }
  }

  /*Modal vindow*/
  var modal = new VanillaModal.default();
  var modalWight;
  modalWight = new VanillaModal.default({
    modal: '.modal-white',
    modalInner: '.modal-inner',
    modalContent: '.modal-content',
    loadClass: 'vanilla-modal-white',
    class: 'modal-visible-white',
    open: '[data-modal-open-white]',
    onBeforeClose: clearResult,
  });

  /*  Рассчет высоты для аккордиона в seo_countres */
  var acc = document.getElementsByClassName("countries-letter");
  if (acc && windowWidth < 768) {
    var i;
    for (i = 0; i < acc.length; i++) {
      acc[i].onclick = function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
          panel.style.maxHeight = null;
        } else {
          panel.style.maxHeight = panel.scrollHeight + "px";
        }
      }
    }
  }


  /*Сортировка стран*/
  writeInInput()
  selectCountry();

  /* Autocomplete */
  var choices = [
    ['Москва', 'Россия', 'MOW'],
    ['Петропавловск-Камчатский', 'Россия', 'PKP'],
    ['Санкт-Петербург', 'Россия', 'SPB'],
    ['Киев', 'Украина', 'KIV']
  ];

  let autocompleteEl = document.querySelectorAll('input[data-autocomplete = "true"]');
  Array.prototype.forEach.call(autocompleteEl, function(selector) {
    new autoComplete({
      selector: selector, //,
      minChars: 1,
      source: function(term, suggest) {
        term = term.toLowerCase();
        var suggestions = [];
        for (i = 0; i < choices.length; i++)
          if (~(choices[i][0] + ' ' + choices[i][1] + ' ' + choices[i][2]).toLowerCase().indexOf(term)) suggestions.push(choices[i]);

        suggest(suggestions);
      },
      renderItem: function(item, search) {
        search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
        return '<div class="autocomplete-suggestion" data-country="' + item[1] + '" data-city="' + item[0] + '" data-iata="' + item[2] + '" data-val="' + search + '">' + '<span class="flyto_city">' + item[0] + '</span>,' + ' <span class="flyto_country">' + item[1] + '</span>' + '<span class="flyto_iata">' + item[2] + '</span>' + '</div>';
      },
      onSelect: function(e, term, item) {
        this.selector.value = item.getAttribute('data-city');
        //alert('Item "'+item.getAttribute('data-langname')+' ('+item.getAttribute('data-lang')+')" selected by '+(e.type == 'keydown' ? 'pressing enter' : 'mouse click')+'.');
      }
    });
  });


  /* Datapicker */

  // let dateTo = $('#dateTo').datepicker({
  //   // Можно выбрать тольо даты, идущие за сегодняшним днем, включая сегодня
  //   minDate: new Date(),
  //   dateFormat: 'dd M, D',
  //   onSelect(formattedDate, date, inst) {
  //     dateBack.update('minDate', date);
  //   }
  // });
  // let dateBack = $('#dateBack').datepicker({
  //   // Можно выбрать тольо даты, идущие за сегодняшним днем, включая сегодня
  //   minDate: new Date(),
  //   dateFormat: 'dd M, D',
  //   classes: 'mf_position_right'
  // })
  let dateTo = $('.dateTo').datepicker({
    // Можно выбрать тольо даты, идущие за сегодняшним днем, включая сегодня
    minDate: new Date(),
    dateFormat: 'dd M, D',
    onSelect: function(formattedDate, date, inst) {
      dateBack.update('minDate', date);
    }
  });
  let dateBack = $('.dateBack').datepicker({
    // Можно выбрать тольо даты, идущие за сегодняшним днем, включая сегодня
    minDate: new Date(),
    dateFormat: 'dd M, D',
    classes: 'mf_position_right'
  }).data('datepicker');

  $('.manyways_date').datepicker({
    // Можно выбрать тольо даты, идущие за сегодняшним днем, включая сегодня
    minDate: new Date(),
    dateFormat: 'dd M, D',
    classes: 'mf_position_manyways'
  });

  /* Main form отмена отрпавки по Enter */
  $('.main-form form').keydown(function(event) {
    if (event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });

  /* В сложной форме удаляем ряд по крестику*/

  let cartRemoveItem = document.querySelectorAll('.manyways__form_del__js');


  if (cartRemoveItem.length > 0) {
    for (var i = 0; i < cartRemoveItem.length; i++) {
      cartRemoveItem[i].onclick = function() {
        removeParent(this)
      }
    }
  }

  /* В сложной форме добавляем перелет */
  let addfly =
    '<div class="row manyways__form_el">' +
    '<input class="manyways__form_cities" data-autocomplete="true" autofocus="" type="text" name="flyfrom"' +
    'placeholder="Город вылета" autocomplete="off" required>' +
    '<input class="manyways__form_cities" data-autocomplete="true" type="text" name="flyto" placeholder="Город прибытия"' +
    'autocomplete="off" required>' +
    '<input type="text" class="datepicker__input manyways_date" placeholder="Дата вылета" name="dateTo" required/>' +
    '<div class="manyways__form_del__js" onclick="removeParent(this);"><div class="close"></div></div>' +
    '</div>';


  $('#addflightrow').click(function(e) {
    e.preventDefault();
    $(".manyways__form__rows").append(addfly);

    let dateTo = $("[name='dateTo']").datepicker({
      // Можно выбрать тольо даты, идущие за сегодняшним днем, включая сегодня
      minDate: new Date(),
      dateFormat: 'dd M, D',
      onSelect(formattedDate, date, inst) {
        dateBack.update('minDate', date);
      }
    });
  })


  // Чекбокс + - 3 дня
  let dateplus_label = document.querySelectorAll('.dateplus_label');
  if (dateplus_label.length > 0) {
    for (let i = 0; i < dateplus_label.length; i++) {
      dateplus_label[i].onclick = function() {
        (this.previousElementSibling.checked) ? this.previousElementSibling.checked = false: this.previousElementSibling.checked = true;
      }
    }
  }

  /* + и - в главной форме в выпадающем списке */
  jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.goods-list__quantity input');
  jQuery('.goods-list__quantity').each(function() {
    var spinner = jQuery(this),
      input = spinner.find('input[type="number"]'),
      btnUp = spinner.find('.quantity-up'),
      btnDown = spinner.find('.quantity-down'),
      min = input.attr('min'),
      max = input.attr('max');

    btnUp.click(function() {
      var oldValue = parseFloat(input.val());
      if (oldValue >= max) {
        var newVal = oldValue;
      } else {
        var newVal = oldValue + 1;
      }
      spinner.find("input").val(newVal);
      spinner.find("input").trigger("change");
    });

    btnDown.click(function() {
      var oldValue = parseFloat(input.val());
      if (oldValue <= min) {
        var newVal = oldValue;
      } else {
        var newVal = oldValue - 1;
      }
      spinner.find("input").val(newVal);
      spinner.find("input").trigger("change");
    });

  });

  /* При клике по + и -, чтобы менялись значения */

  $('.oneway__form .quantity-button, .oneway__form .fly_class_label_js').click(function() {
    getSummInputs('.oneway__form');
  })

  $('.manyways__form .quantity-button, .manyways__form .fly_class_label_js').click(function() {
    getSummInputs('.manyways__form');
  })

  /* DROP DOWNS */

  let dropdown = new CloseOutClick();

  /* Подсчет человек в dropdown */
  let dd_container = document.querySelector('.stm_dropdown');
  if (dd_container) {
    let inputs = dd_container.querySelectorAll('input');
    Array.prototype.forEach.call(inputs, function(input) {
      input.addEventListener('change', function() {
        getSummInput();
      })

    });
  }


  /* Смена направлений в главной форме */
  let changeDist = document.querySelector('.mf_change_dest');
  if (changeDist) {
    changeDist.addEventListener('click', function() {
      let flyfrom = document.getElementById('flyfrom');
      let flyto = document.getElementById('flyto');

      let _flyfrom = flyfrom.value;
      let _flyto = flyto.value;

      flyfrom.value = _flyto;
      flyto.value = _flyfrom;
    })
  }

  /* Смена формы */
  $('.tomanyeway__js').click(function() {
    $('.oneway__form').removeClass('is-visible');
    $('.manyways__form').addClass('is-visible');
  });

  $('.tooneway__js').click(function() {
    $('.manyways__form').removeClass('is-visible');
    $('.oneway__form').addClass('is-visible');
  });

  // Вывод загруженных файлов на страницу

  let file_input = document.getElementById('resume');
  if (file_input) {
    let label = document.getElementById('upload-label');

    file_input.addEventListener('change', function() {
      let wrap = document.getElementById('upload-file');

      for (let i = 0; i < file_input.files.length; i++) {
        let file = document.createElement('SPAN');

        file.className = 'upload-file';
        file.innerHTML = `${file_input.files[i].name}`;
        if (wrap) {
          wrap.innerHTML = '';
          wrap.appendChild(file);
        }
      }

    })
  }


  /* Сворачиваем блок на льготных билетах */

  let collabsile_node = document.querySelectorAll('.collabsible_js');
  if (collabsile_node.length > 0) {
    /* Определяем мобильная версия или нет */
    let _version = getComputedStyle(collabsile_node[0].querySelector('.lgot_text_js'));
    console.log(_version.height);

    let val = "45px"; // Значение по умолчанию
    if (parseInt(_version.height) < 50) {
      val = "45px";
    } else {
      val = "205px";
    }

    let collabsile = Array.prototype.slice.call(collabsile_node);
    collabsile.forEach(function(item) {
      item.addEventListener('click', function(e) {
        if (e.target == item.querySelector('.lgot_text_collapse_js')) {
          if (item.querySelector('.lgot_text_js').classList.contains('is-collapse_js')) {
            e.target.innerText = 'Узнать больше';
            item.querySelector('.lgot_text_js').classList.remove('is-collapse_js')
            transition({
              element: item.querySelector('.lgot_text_js'),
              prop: "height",
              val: val
            });

          } else {
            e.target.innerText = 'Свернуть';
            item.querySelector('.lgot_text_js').classList.add('is-collapse_js')
            transition({
              element: item.querySelector('.lgot_text_js'),
              prop: "height",
              val: "auto"
            });
          }
        }
      });
    });
  }

  /* Сворачиваем блок в справочном разделе */

  let sp_collabsile_node = document.querySelectorAll('.sp_collabsible_js');

  if (sp_collabsile_node.length > 0) {

    /* Определяем мобильная версия или нет */
    let _version = getComputedStyle(sp_collabsile_node[0].querySelector('.lgot_text_js'));
    console.log(_version.height)
    let val = "45px"; // Значение по умолчанию
    if (parseInt(_version.height) < 50) {
      val = "45px";
    } else {
      val = "55px";
    }

    let collabsile = Array.prototype.slice.call(sp_collabsile_node);
    collabsile.forEach(function(item) {
      item.addEventListener('click', function(e) {
        if (e.target == item.querySelector('.lgot_text_collapse_js')) {
          if (item.querySelector('.lgot_text_js').classList.contains('is-collapse_js')) {
            e.target.innerText = 'Подробнее';
            item.querySelector('.lgot_text_js').classList.remove('is-collapse_js')
            transition({
              element: item.querySelector('.lgot_text_js'),
              prop: "height",
              val: val
            });

          } else {
            e.target.innerText = 'Свернуть';
            item.querySelector('.lgot_text_js').classList.add('is-collapse_js')
            transition({
              element: item.querySelector('.lgot_text_js'),
              prop: "height",
              val: "auto"
            });
          }
        }
      });
    });
  }


  /* Выделяем текст при фокусе на элементе */
  setTextBoxes();


  /* Форма ответа в комментариях */
  let comments = document.querySelector('.comments_js');

  if (comments) {
    let commentForm = document.querySelector('.comment-answer_js'),
      div = commentForm.querySelector('div');

    comments.addEventListener('click', function(e) {

      if (e.target.classList.contains('comment_link_js')) {
        let containerClass = 'comment_js'; // class комментария, от него мы отталкивается, чтобы найти имя и если какие-то еще нужно данные подставить в форму ответа
        let container = e.target; // текущий элемент, от него наничаем поиск вверх
        /* поход вверх пока не наткнемся на контейнер */

        // цикл двигается вверх от target к родителям до table
        while (!container.classList.contains(containerClass)) {
          // if (container.classList.contains(containerClass)) {
          //     console.log(container)
          //     return;
          // }
          container = container.parentNode

        }

        let name = container.querySelector('.comment_autor_name_js').innerHTML; // берем имя автора, чтобы вставить в форму
        let nameAnswer = commentForm.querySelector('.comment_autor_to-form__js'),
          parentContainer = container.parentNode;

        nameAnswer.innerText = name;
        commentForm.classList.remove('invisible');
        parentContainer.insertBefore(commentForm, parentContainer.children[1]);

      }

      if (e.target.classList.contains('comments_close_js')) {
        e.preventDefault();

        let annswerContainer = e.target;

        while (!annswerContainer.classList.contains('comment-answer_js')) {
          annswerContainer = annswerContainer.parentNode;
        }

        annswerContainer.parentNode.removeChild(annswerContainer)
      }
    });
  }
}; // END Document load


function infinitComments() {
  let container = document.querySelector('.comments_js'),
    btn = document.querySelector('.view-more-button'),
    count = 0,
    shownItems = count + 6;

  if (container) {

    $('.comments_js').infiniteScroll({
      // options
      path: function() {
        return './json/comments.json';
      },
      append: false,
      button: '.view-more-button',
      // using button, disable loading on scroll
      scrollThreshold: false,
      status: '.page-load-status',
      history: false,
      responseType: 'text',
    });

    $('.comments_js').on('load.infiniteScroll', function(event, response) {
      // parse JSON
      var data = JSON.parse(response);
      // do something with JSON...
      console.log('ok', data)

      for (let i = count; i < shownItems; i++) {
        if (data[i]) {
          createComment(data[i], container)


          if (!data[i + 1]) {
            //здесь можно показать сообщение об отсутствии данных для загрузки
            btn.style.display = 'none'
            btn.parentNode.parentNode.parentNode.style.display = 'none'
          }
        }
      }

      //чтоб выводить по 6 картинок за раз
      count = shownItems;
      shownItems = 3 + count;
    });
  }
}

function createComment(comment, container) {
  let item = document.createElement('li');

  item.innerHTML = `<article class="comment comment_js">
                            <div class="comment_avatar">
                                <img src="${comment.img}" alt="">
                            </div>
                            <div class="comment_body">
                                <div class="comment_autor">
                                    <span class="comment_autor_name comment_autor_name_js">${comment.name}</span>
                                </div>
                                <div class="comment_text">
                                    <span>${comment.text}</span>
                                </div>
                                <div class="comment_meta">
                                    <time datetime="2018-12-28T18:18:18+04:00" class="comment_time">28.12.2018 22:45
                                    </time>
                                    <button class="btn_link comment-btn_link comment_link_js">Ответить</button>
                                </div>
                            </div>
                        </article>`

  container.appendChild(item);

  if (comment.subComments) {
    let subUl = document.createElement('ul');
    subUl.classList = 'comments_children'

    item.appendChild(subUl)

    comment.subComments.forEach(function(item) {
      createComment(item, subUl)
    })
  }
}

infinitComments()
// /*Masonry*/
$('.grid').masonry({
  itemSelector: '.grid-item',
  columnWidth: '.grid-sizer',
  gutter: '.gutter-sizer',
  percentPosition: true,
  // fitWidth: true,
  transitionDuration: '0.40s'
});

// /*infinity scroll*/

// var nextPages = [
//     window.location.origin + '/index',
//     window.location.origin + '/about',
//     window.location.origin + '/chart',
// ];
function infinitContent() {

  let container = document.querySelector('.scroll-container'),
    btn = document.querySelector('.view-more-button'),
    count = 0,
    shownItems = count + 6;

  if (container) {

    $('.scroll-container').infiniteScroll({
      // options
      path: function() {
        return './json/places.json';
      },
      append: false,
      button: '.view-more-button',
      // using button, disable loading on scroll
      scrollThreshold: false,
      status: '.page-load-status',
      history: false,
      responseType: 'text',
    });

    $('.scroll-container').on('load.infiniteScroll', function(event, response) {
      // parse JSON
      var data = JSON.parse(response);
      // do something with JSON...

      for (let i = count; i < shownItems; i++) {
        if (data[i]) {
          let item = document.createElement('article');

          item.className = 'col-md-4 col-sm-6 col-xs-12';
          item.innerHTML = `
                    <div class="blog__page">
                        <figure class="blog__photo">
                            <img src="${data[i].img}" alt="" class="icons-block__img">
                        </figure>
                        <div class="blog__meta">
                            <div class="blog__time_autor">
                              <span class="autor">${data[i].name}</span>
                              <time datetime="${data[i].data}" class="time">${data[i].data}</time>
                             </div>
                             <h2 class="blog__title">${data[i].title}</h2>
                             <div class="blog__text">
                                <p>${data[i].text}</p>
                            </div>
                        </div>
                    </div>`;

          container.appendChild(item);

          if (!data[i + 1]) {
            //здесь можно показать сообщение об отсутствии данных для загрузки
            btn.style.display = 'none'
          }
        }
      }

      //чтоб выводить по 6 картинок за раз
      count = shownItems;
      shownItems = 6 + count;
    });
  }

}

infinitContent()

let count = 0,
  shownItems = count + 3;

function searchResult() {

  let container = document.querySelector('#search_result'),
    btn = document.querySelector('.result-button')
  // count = 0,
  // shownItems = count + 3;

  if (container) {

    $('#search_result').infiniteScroll({
      // options
      path: function() {
        return './json/result.json';
      },
      append: false,
      button: '.result-button',
      // using button, disable loading on scroll
      scrollThreshold: false,
      status: '.page-load-status',
      history: false,
      responseType: 'text',
    });

    $('#search_result').on('load.infiniteScroll', function(event, response) {
      // parse JSON
      var data = JSON.parse(response);
      // do something with JSON...

      for (let i = count; i < shownItems; i++) {
        if (data[i]) {
          let item = document.createElement('div');

          item.className = 'result_element';

          item.innerHTML = ` <h2>Купить билеты в <span class="highlighted">${data[i].place}</span></h2>
                        <div class="descr">
                            <p>${data[i].text}</p>
                        </div>
                        <div class="separator"></div>`;

          container.appendChild(item);

          if (!data[i + 1]) {
            //здесь можно показать сообщение об отсутствии данных для загрузки
            btn.style.display = 'none'
          }
        }
      }

      //чтоб выводить по 3 результата за раз
      count = shownItems;
      shownItems = 3 + count;
    });
  }

}

searchResult()

function clearResult() {
  let container = document.querySelector('#search_result'),
    btn = document.querySelector('.result-button');

  if (container) {
    container.innerHTML = '';
    count = 0;
    shownItems = 3 + count;

    btn.style.display = 'inline-block'

  }
}


/* Список стран и фильтрация по ним */

let arrCountrys = [{
    name: "Абхазия",
    href: "google.com"
  },
  {
    name: "Грузия",
    href: "google.com"
  },
  {
    name: "Турция",
    href: "google.com"
  },
  {
    name: "Китай",
    href: "google.com"
  },
  {
    name: "Болгария",
    href: "google.com"
  },
  {
    name: "Румыния",
    href: "google.com"
  },
  {
    name: "Польша",
    href: "google.com"
  },
  {
    name: "Чехия",
    href: "google.com"
  },
  {
    name: "Таиланд",
    href: "google.com"
  },
  {
    name: "Саудовкая Аравия",
    href: "google.com"
  },

];

function writeInInput() {
  let input = document.querySelector('input[name="countrys"]');


  if (input) {
    let alpabetWrap = document.querySelector('.alphabet-wrap'),
      links = [...alpabetWrap.querySelectorAll('a')],
      items = [...document.querySelectorAll('.country')];

    input.oninput = function() {
      let activeWrap = document.querySelector('.country__output'),
        list = activeWrap.querySelector('ul'),
        correctValue = this.value.toLowerCase().trim();


      activeWrap.classList.add('active-block');

      items.forEach(function(item) {
        item.classList.remove('active-block');
        item.style.display = 'none'
      })

      links.forEach(function(item) {
        item.classList.remove('active-link')
      })

      function filterCountrys(obj) {
        if (obj.name.toLowerCase().trim().indexOf(correctValue) != -1) {
          return true;
        } else {
          return false;
        }
      }

      let correctArr = arrCountrys.filter(filterCountrys);

      list.innerHTML = '';

      correctArr.forEach(function(item) {

        let li = document.createElement('LI');
        li.innerHTML = `<a href="${item.href}">${item.name}</a>`;

        list.appendChild(li);
      })
    }
  }
}

function selectCountry() {
  let alphabet = document.querySelector('.countrys_js');

  if (alphabet) {
    let links = alphabet.querySelectorAll('A[data-country]'),
      wraps = alphabet.querySelectorAll('.country-wrap'),
      countrys = alphabet.querySelectorAll('.country'),
      select = alphabet.querySelectorAll('select');

    if (alphabet) {
      alphabet.onclick = function(e) {
        let target = e.target;

        if (target.hasAttribute('data-country') && target.tagName == 'A') {
          e.preventDefault();


          deleteActive(links, wraps)
          showCountry(target.getAttribute('data-country'), target)
        }
      }
    }

    if (select.length > 0) {
      for (let i = 0; i < select.length; i++) {

        select[i].onchange = function() {

          deleteActive(links, wraps, countrys)
          showCountry(this.value)
        };

      }
    }
  }
}

function deleteActive(items, countrysWrap) {

  for (let i = 0; i < items.length; i++) {

    items[i].classList.remove('active-link')

  }

  for (let i = 0; i < countrysWrap.length; i++) {

    countrysWrap[i].style.display = 'none';

  }
}

function showCountry(attr, link) {
  let countrys = document.querySelector('.countrys'),
    selector = `[data-country="${attr}"`,
    output = document.querySelector('.country__output'),
    countryBlock = countrys.querySelector(selector);


  if (countryBlock) {
    let parent = countryBlock.parentNode,
      items = parent.querySelectorAll('.country');

    for (let i = 0; i < items.length; i++) {

      items[i].style.display = 'none'
      items[i].classList.remove('active-block')
    }

    output.classList.remove('active-block')
    countryBlock.classList.add('active-block');
    parent.classList = '';
    parent.style.display = 'block';
    parent.classList.add('col-xs-12', 'country-wrap');

    if (link) {
      link.classList.add('active-link')

    }
  }
}

let spravContent = document.getElementById('spravSection')

/*Sprav accordion*/
if (spravContent) {

  spravContent.addEventListener('click', function(e) {
    let target = e.target;

    while (target != this) {
      if (target.classList.contains('acco__icon_js')) {
        e.preventDefault();

        showSpravItem(target)
        return;
      } else if (target.classList.contains('acco__show-text')) {
        e.preventDefault();

        showSpravText(target)
        return;
      }
      target = target.parentNode;
    }

  })
  chooseItem()
}

function showSpravItem(target) {
  let parent = target.parentNode;
  parent.classList.toggle('acco__item-active')
  target.classList.toggle('acco__icon-active')
}

function showSpravText(target) {
  let parent = target.parentNode;

  parent.classList.toggle('acco__hidden-text--active')

  if (parent.classList.contains('acco__hidden-text--active')) {
    target.innerText = 'Свернуть'
  } else {
    target.innerText = 'Подробнее'
  }
}

function chooseItem() {
  let select = document.getElementById('sprav-list'),
    selectKarier = document.getElementById('karier'),
    items = document.querySelectorAll('.acco__item'),
    selectWhere = document.getElementById('whereAvia'),
    selectFrom = document.getElementById('fromAvia'),
    selectChipPriceM = document.getElementById('selectChipPriceM'),
    selectChipPriceD = document.getElementById('selectChipPriceD'),
    value;

  if (select) {
    select.addEventListener('change', function() {
      value = this.value;
      let selector = `[data-id="${value}"]`,
        activeItem = document.querySelector(selector),
        icon = activeItem.querySelector('.acco__icon_js');

      for (let i = 0; i < items.length; i++) {
        items[i].style.display = 'none';
      }

      activeItem.style.display = 'block';
      activeItem.classList.add('acco__item-active');
      icon.classList.add('acco__icon-active');
    })
  }

  if (selectKarier) {
    selectKarier.addEventListener('change', function() {
      value = this.value;
      items = document.querySelectorAll('.karier_js');
      if (value != '') {
        let selector = `[data-id="${value}"]`,
          activeItem = document.querySelector(selector);

        for (let i = 0; i < items.length; i++) {
          items[i].style.display = 'none';
        }
        activeItem.style.display = 'block';
      } else {

        for (let i = 0; i < items.length; i++) {
          items[i].style.display = 'block';
        }
      }
    })
  }

  if (selectChipPriceM) {
    items = document.querySelectorAll('.chipPrice_js');
    let activeItem = [...document.querySelectorAll('.chipPrice_js')];
    activeItem.forEach(function(item) {
      item.classList.add('invisible');
    });

    // Ищем активный элемент в десктопной версии, именно он определяет какой блок со слайдером будет активен
    let navItem = selectChipPriceD.querySelector('[data-firstactive = "selected"]');
    let firstActiveItem = document.querySelector(`[data-id="${navItem.dataset.value}"]`);
    firstActiveItem.classList.remove('invisible');

    // При загрузке делаем первый активный элемент подсвеченным
    navItem.classList.add('active');


    selectChipPriceM.addEventListener('change', function() {
      value = this.value;

      if (value != '') {
        let selector = `[data-id="${value}"]`,
          activeItem = document.querySelector(selector);

        for (let i = 0; i < items.length; i++) {
          items[i].classList.add('invisible');
        }
        activeItem.classList.remove('invisible');
        let sliderStrater = activeItem.querySelectorAll('.js_slider-starter');
        if (sliderStrater.length > 0) {
          for (var j = sliderStrater.length - 1; j >= 0; j--) {
            lory(sliderStrater[j], {
              infinite: 3
            });
          }
        }

      } else {
        for (let i = 0; i < items.length; i++) {
          /* Заново пересоздаем слайдер */
          items[i].classList.remove('invisible');
          let sliderStrater = items[i].querySelectorAll('.js_slider-starter');
          if (sliderStrater.length > 0) {
            for (var j = sliderStrater.length - 1; j >= 0; j--) {
              lory(sliderStrater[j], {
                infinite: 3
              });
            }
          }
        }
      }
    })

    selectChipPriceD.addEventListener('click', function(e) {
      if (e.target.tagName != "LI") {
        return;
      }
      value = e.target.dataset.value;

      /* Присваиваем активный класс элементу, по которому кликнули */
      let _nav_li = [...selectChipPriceD.querySelectorAll('.tab_nav_li')];
      _nav_li.forEach(function(item) {
        item.classList.remove('active');
      });
      e.target.classList.add('active');


      if (value != '') {
        let selector = `[data-id="${value}"]`,
          activeItem = document.querySelector(selector);

        for (let i = 0; i < items.length; i++) {
          items[i].classList.add('invisible');
        }
        activeItem.classList.remove('invisible');
        let sliderStrater = activeItem.querySelectorAll('.js_slider-starter');
        if (sliderStrater.length > 0) {
          for (var j = sliderStrater.length - 1; j >= 0; j--) {
            lory(sliderStrater[j], {
              infinite: 3
            });
          }
        }

      } else {
        for (let i = 0; i < items.length; i++) {
          /* Заново пересоздаем слайдер */
          items[i].classList.remove('invisible');
          let sliderStrater = items[i].querySelectorAll('.js_slider-starter');
          if (sliderStrater.length > 0) {
            for (var j = sliderStrater.length - 1; j >= 0; j--) {
              lory(sliderStrater[j], {
                infinite: 3
              });
            }
          }
        }
      }
    })
  }

  if (selectWhere) {
    selectWhere.addEventListener('change', function() {
      if (this.value == '') {
        if (selectFrom.value == '') {
          let activeItem = [...document.querySelectorAll('.direct_js')]

          activeItem.forEach(function(item) {
            item.style.display = 'flex';
          })
        } else {
          selectDirection(selectFrom.value, this.value)
        }
      } else {
        selectDirection(selectFrom.value, this.value)
      }
    })

    selectFrom.addEventListener('change', function() {

      if (this.value == '') {

        if (selectWhere.value == '') {

          let activeItem = [...document.querySelectorAll('.direct_js')]

          activeItem.forEach(function(item) {
            item.style.display = 'flex';
          })

        } else {
          selectDirection(this.value, selectWhere.value)
        }

      } else {
        selectWhere.value = ''
        selectDirection(this.value, selectWhere.value)
      }

    })
  }

  function selectDirection(valueFrom, valueWhere) {
    let itemsArr = document.querySelectorAll('.acco__item'),
      icon = itemsArr[0].querySelector('.acco__icon_js'),
      direct = [],
      directTrue = [],
      selector,
      list = [...document.querySelectorAll('.acco__list')];

    if (valueFrom != '') {
      selector = valueWhere != '' ? `[data-id="${valueFrom + valueWhere}"]` : `[data-from="${valueFrom}"]`

    } else {
      selector = `[data-where="${valueWhere}"]`
    }

    for (let i = 0; i < itemsArr.length; i++) {
      direct.push(itemsArr[i].querySelectorAll('.direct_js'))
      directTrue.push(itemsArr[i].querySelectorAll(selector))
    }

    direct.forEach(function(item) {
      item.forEach(function(item) {
        let parent = item.parentNode.parentNode;
        parent.classList.remove('not-empty')
        item.style.display = 'none'
      })
    });

    directTrue.forEach(function(item) {
      // console.log(item)

      if (item.length === 0) {

        list.forEach(function(item) {
          let answer = item.querySelector('.direct__nothing');
          answer.style.display = 'block'
        })

      } else {

        item.forEach(function(item) {
          // console.log(item)
          let parent = item.parentNode.parentNode;
          parent.classList.add('not-empty')

          item.style.display = 'flex';

        })
      }
    });

    itemsArr[0].classList.add('acco__item-active');
    icon.classList.add('acco__icon-active');
  }
}

/* Полифил matches */
(function(e) {

  e.matches || (e.matches = e.matchesSelector || function(selector) {
    var matches = document.querySelectorAll(selector),
      th = this;
    return Array.prototype.some.call(matches, function(e) {
      return e === th;
    });
  });

})(Element.prototype);

/* Dropdown and close outclick*/
function getSummInputs(form) {
  let people = document.querySelectorAll(form + ' .people_qua');
  let summ = Number(people[0].value) + Number(people[1].value) + Number(people[2].value);
  switch (summ) {
    case 2:
    case 3:
    case 4:
      summ = summ + ' человекa';
      break;
    default:
      summ = summ + ' человек'
      break;
  }

  let fly_class_js = document.querySelector(form + ' .fly_class_js'); //
  (fly_class_js.checked) ? summ = summ + ', бизнес': summ = summ + ', эконом';

  document.querySelector(form + ' .mf_people').value = '';
  document.querySelector(form + ' .mf_people').value = summ;

};

function CloseOutClick(opt) {
  let container = document.body || opt.container,
    selectorForHide = 'stm_dropdown' || opt.selectorForHide,
    btnforDropDown = 'btn_dropdown_js' || opt.btnforDropDown;

  /* Клик вне элемента */
  container.onclick = function(event) {
    var target = event.target;
    // Если мы сразу кликнули по контейнеру
    if (target == container) {
      let targetList = document.querySelectorAll('.' + selectorForHide);
      for (var i = targetList.length - 1; i >= 0; i--) {
        targetList[i].classList.remove('is-visible');

      }
    }
    while (target != container) {
      if (!target) {
        return
      }

      if (target.classList.contains(selectorForHide)) {
        return;
      } else if (target.classList.contains(btnforDropDown)) {
        return;
      }
      target = target.parentNode;
      if (target == container) {
        // Дошли до контейнера
        let targetList = document.querySelectorAll('.' + selectorForHide);
        for (var i = targetList.length - 1; i >= 0; i--) {

          let parent = targetList[i].parentNode;

          parent.classList.remove('active')
          targetList[i].classList.remove('is-visible');
        }
      }
    }
  }

  /* Первый запуск по-умолчанию*/
  let fakeInput = document.querySelectorAll('.' + btnforDropDown);
  for (var i = fakeInput.length - 1; i >= 0; i--) {
    fakeInput[i].addEventListener('click', function() {
      // Скрываем все открытые выпадашки
      let targetList = document.querySelectorAll('.' + selectorForHide);
      // for (var j = targetList.length - 1; j >= 0; j--) {
      //     targetList[j].classList.remove('is-visible');
      // }
      // Открываем нашу
      if (this.nextElementSibling.classList.contains('is-visible')) {
        this.nextElementSibling.classList.remove('is-visible')

      } else {
        this.parentNode.classList.add('active')
        this.nextElementSibling.classList.add('is-visible');
      }

    })
  }
}

/* Функция удаления родителя в сложной форме */
function removeParent(_this) {
  let parent = _this;
  for (var j = 0; j < 5; j++) {

    if (parent.classList.contains('manyways__form_el')) {
      parent.classList.add('remove-js');
      setTimeout(function() {
        parent.parentElement.removeChild(parent)
      }, 500);

      break;
    } else {
      parent = parent.parentElement;
    }
  }
}

let mainForm = (function(e) {
    let wrapMainForm = document.querySelector('.main_form_tab');

    if (wrapMainForm) {
      wrapMainForm.addEventListener('click', function(e) {
        let active = document.activeElement;
        if (active.tagName == 'INPUT') {
          $(active).select()
        }

        if (active)

          return;
      })
    }

    /** reset form button **/
    let reset = [...document.querySelectorAll('.reset_form_js')];

    reset.forEach((item, index) => {
      item.addEventListener("click", function(e) {
        e.preventDefault()
        let form = document.getElementById('mainForm_manyways');
        let input = form.getElementsByTagName("INPUT");
        for (var i = 0; i < input.length; i++) {
          input[i].value = input[i].defaultValue;
        }
      })
    });

  })()





  /* Чтобы можно было делать  transition to height: auto */
  /*!
   * transition-to-from-auto 0.5.2
   * https://github.com/75lb/transition-to-from-auto
   * Copyright 2015 Lloyd Brookes <75pound@gmail.com>
   */
  ! function(e, t) {
    "use strict";

    function n(e, t) {
      var n, o, i = e.element,
        a = e.val,
        s = e.prop,
        l = i.style;
      if (!d) return l[s] = a;
      if (i.hasAttribute(u)) i.removeEventListener(f, t.l);
      else {
        if (l[d] = "none", n = r(i)[s], l[s] = "auto", o = r(i)[s], n === a || "auto" === a && n === o) return;
        t.auto = o, i.setAttribute(u, 1), l[s] = n, i.offsetWidth, l[d] = e.style
      }
      l[s] = "auto" === a ? t.auto : a, t.l = function(e) {
        e.propertyName === s && (i.removeAttribute(u), i.removeEventListener(f, t.l), "auto" === a && (l[d] = "none", l[s] = a))
      }, i.addEventListener(f, t.l)
    }

    function o(e) {
      var o, i, r = e.element;
      "string" == typeof r && (r = t.querySelector(r)), r = e.element = r instanceof Node ? r : !1, e.prop = e.prop || "height", e.style = e.style || "", r && (i = a.indexOf(r), ~i ? o = s[i] : (o = {}, a.push(r), s.push(o)), n(e, o))
    }

    var i, r = e.getComputedStyle,
      u = "data-ttfaInTransition",
      a = [],
      s = [],
      d = !1,
      f = !1,
      l = t.createElement("a").style;
    void 0 !== l[i = "webkitTransition"] && (d = i, f = i + "End"), void 0 !== l[i = "transition"] && (d = i, f = i + "end"), o.prop = d, o.end = f, "object" == typeof module && module.exports ? module.exports = o : "function" == typeof define && define.amd ? define(function() {
      return o
    }) : e.transition = o
  }(window, document);

(function(window, document) {
  "use strict";

  var getComputedStyle = window.getComputedStyle;
  var isTransition = "data-ttfaInTransition";

  var elements = [];
  var data = [];

  // Transition detecting
  var transitionProp = false;
  var transitionEnd = false;
  var testStyle = document.createElement("a").style;
  var testProp;

  if (testStyle[testProp = "webkitTransition"] !== undefined) {
    transitionProp = testProp;
    transitionEnd = testProp + "End";
  }

  if (testStyle[testProp = "transition"] !== undefined) {
    transitionProp = testProp;
    transitionEnd = testProp + "end";
  }

  function process(options, data) {
    var el = options.element;
    var val = options.val;
    var prop = options.prop;
    var style = el.style;
    var startVal;
    var autoVal;

    if (!transitionProp) {
      return style[prop] = val;
    }

    if (el.hasAttribute(isTransition)) {
      el.removeEventListener(transitionEnd, data.l);
    } else {
      style[transitionProp] = "none";

      startVal = getComputedStyle(el)[prop];
      style[prop] = "auto";
      autoVal = getComputedStyle(el)[prop];

      // Interrupt
      if (startVal === val || val === "auto" && startVal === autoVal) {
        return;
      }

      data.auto = autoVal;
      el.setAttribute(isTransition, 1);

      // Transition
      style[prop] = startVal;
      el.offsetWidth;
      style[transitionProp] = options.style;
    }

    style[prop] = val === "auto" ? data.auto : val;

    data.l = function(e) {
      if (e.propertyName === prop) {
        el.removeAttribute(isTransition);
        el.removeEventListener(transitionEnd, data.l);
        if (val === "auto") {
          /* avoid transition flashes in Safari */
          style[transitionProp] = "none";
          style[prop] = val;
        }
      }
    };

    el.addEventListener(transitionEnd, data.l);
  }

  /**
   @param options {Object}
   @param options.element {string | element} - The DOM element or selector to transition
   @param options.val {string} - The value you want to transition to
   @param [options.prop] {string} - The CSS property to transition, defaults to `"height"`
   @param [options.style] {string} - The desired value for the `transition` CSS property (e.g. `"height 1s"`). If specified, this value is added inline and will override your CSS. Leave this value blank if you already have it defined in your stylesheet.
   @alias module:transition-to-from-auto
   */
  function transition(options) {
    var element = options.element;
    var datum;
    var index;

    if (typeof element === "string") {
      element = document.querySelector(element);
    }

    element = options.element = element instanceof Node ? element : false;
    options.prop = options.prop || "height";
    options.style = options.style || "";

    if (element) {
      index = elements.indexOf(element);
      if (~index) {
        datum = data[index];
      } else {
        datum = {};
        elements.push(element);
        data.push(datum);
      }

      process(options, datum);
    }
  }

  /**
   The name of the vendor-specific transition CSS property
   @type {string}
   @example
   el.style[transition.prop + 'Duration'] = '1s';
   */
  transition.prop = transitionProp;

  /**
   * The name of the [transition end event](https://developer.mozilla.org/en-US/docs/Web/Events/transitionend) in the current browser (typically `"transitionend"` or `"webkitTransitionEnd"`)
   * @type {string}
   * @example
   * el.addEventListener(transition.end, function(){
   *     // the transition ended..
   * });
   */
  transition.end = transitionEnd;


  if (typeof module === "object" && module.exports) {
    module.exports = transition;
  } else if (typeof define === "function" && define.amd) {
    define(function() {
      return transition;
    });
  } else {
    window.transition = transition;
  }
})(window, document);


function setTextBoxes() {
  let txtFields = document.getElementsByTagName('input');
  let textareaFields = document.getElementsByTagName('textarea');

  for (var i = 0, len = txtFields.length; i < len; i++) {
    if (txtFields[i].type == 'text' || txtFields[i].type == 'password') {
      txtFields[i].onfocus = function() {
        this.select();
      }
    }
  }

  for (var i = 0, len = textareaFields.length; i < len; i++) {
    textareaFields[i].onfocus = function() {
      this.select();
    }
  }
}
$(function() {
  $('.g-btn-switch-price').click(function() {
    $(this).closest('.price-list').find('.price-list__content-wrap').slideToggle(500);
    $(this).html($(this).html() == 'Скрыть цены' ? 'Посмотреть цены' : 'Скрыть цены');
    return false;
  })
});
// new

$(function() {
  $('.btn-open-f-list').click(function() {
    $(this).closest('.g-filter').find('.g-filter__inner').slideToggle(500);
    var text = $(this).html() == 'фильтры' ? 'скрыть фильтры' : 'фильтры'
    $(this).html(text);
    return false;
  })
});

$(function() {
  $('.g-filter__menu li').on('click', function() {
    if (this.classList.contains('disabled')) {
      this.classList.remove('open');

    } else {
      $(this).find('ul').toggle();
      $(this).toggleClass('open')
    }

  });

});
$(function() {
  $('.d-menu > a').on('click', function() {
    $(this).parent().find('.dropdown-menu__wrap').toggle();
    $(this).toggleClass('open')
  });
  $('.g-icon-close').on('click', function() {
    $(this).closest('.dropdown-menu__wrap').toggle();
    $(this).removeClass('open')
  });

});
$(function() {
  $('.link-more-t').click(function() {
    $(this).closest('.g-item').find('.b-more-tarifs').slideToggle(500);
    var text = $(this).html() == 'Скрыть тарифы' ? 'Показать еще тарифы' : 'Скрыть тарифы'
    $(this).html(text);
    return false;
  })
});
$(document).on('click', '.g-payment__line span', function() {
  $(this).closest('.g-payment-item__row').find('.g-price').removeClass('checked');
  $(this).closest('.g-payment__line').find('.g-price').addClass('checked');
});
