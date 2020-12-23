//get the item information when a customer clicks on each item
function getElementsofItem(container) {
  //get the small Images for product Details
  var imgText = container.querySelector('img').getAttribute('src');
  var smallImg1 = imgText.replace('.jpg', '') + '-1.jpg';
  var smallImg2 = imgText.replace('.jpg', '') + '-2.jpg';
  var smallImg3 = imgText.replace('.jpg', '') + '-3.jpg';
  var smallImg4 = imgText.replace('.jpg', '') + '-4.jpg';
  //extract the onSales and prices
  var itemInfo = {
    title: container.querySelector('h4').innerText,
    price: parseFloat(container.querySelector('p').innerText.replace('$', '')),
    image: {
      mainImg: container.querySelector('img').src,
      smallImage1: smallImg1,
      smallImage2: smallImg2,
      smallImage3: smallImg3,
      smallImage4: smallImg4
    },
    description:
      "Give your summer wardrobe a style upgrade with the HRX Men's Active T-shirt. Team it with a pair of shorts for your morning workout or a denims for an evening out with the guys"
  };
  return itemInfo;
}

function getItem() {
  document.querySelector('#item1').onclick = function() {
    localStorage.clear();
    var container1 = document.querySelector('#item1').parentElement;
    var itemInfo = getElementsofItem(container1);
    localStorage.setItem('itemInfo', JSON.stringify(itemInfo));
  };

  document.querySelector('#item2').onclick = function() {
    localStorage.clear();
    var container = document.querySelector('#item2').parentElement;
    var itemInfo = getElementsofItem(container);
    localStorage.setItem('itemInfo', JSON.stringify(itemInfo));
  };
  document.querySelector('#item3').onclick = function() {
    localStorage.clear();
    var container = document.querySelector('#item3').parentElement;
    var itemInfo = getElementsofItem(container);
    localStorage.setItem('itemInfo', JSON.stringify(itemInfo));
  };
  document.querySelector('#item4').onclick = function() {
    localStorage.clear();
    var container = document.querySelector('#item4').parentElement;
    var itemInfo = getElementsofItem(container);
    localStorage.setItem('itemInfo', JSON.stringify(itemInfo));
  };
}

function sortByRatingHighToLow() {
  var temp;
  var itemsOnRating = window.allItemsData;
  for (var i = 0; i < itemsOnRating.length - 1; i++) {
    for (var j = i; j < itemsOnRating.length; j++) {
      if (itemsOnRating[i].rating < itemsOnRating[j].rating) {
        temp = itemsOnRating[i];
        itemsOnRating[i] = itemsOnRating[j];
        itemsOnRating[j] = temp;
      }
    }
  }
  return itemsOnRating;
}

function displayRating(itemsElement) {
  for (var i = 0; i < itemsElement.length; i++) {
    let rating = itemsElement[i].getElementsByClassName('rating')[0];
    let itemRating = window.allItemsData[i].rating;

    let addedRating = rating.querySelectorAll('i');
    for (let j = 0; j < 5; j++) {
      if (j + 1 - itemRating <= 0) {
        console.log(j + 1 - itemRating);
        addedRating[j].classList.add('fa');
        addedRating[j].classList.add('fa-star');
      } else if (j + 1 - itemRating === 0.5) {
        addedRating[j].classList.add('fa');
        addedRating[j].classList.add('fa-star-half-o');
      } else {
        console.log('wht');
        addedRating[j].classList.add('fa');
        addedRating[j].classList.add('fa-star-o');
      }
    }
  }
}

function displayItemOnHighRating() {
  var column = document.querySelectorAll('.col-4');
  let allItemsOnHighRating = sortByRatingHighToLow();
  //set Page1 as default
  for (var i = 0; i < column.length; i++) {
    column[i].querySelector('img').src = allItemsOnHighRating[i].image.mainImg;
    console.log(allItemsOnHighRating[i].image.mainImg);
    column[i].querySelector('h4').innerText = allItemsOnHighRating[i].title;
    column[i].querySelector('p').innerText = '$' + allItemsOnHighRating[i].price.toFixed(2);
  }
  displayRating(column);
}

function loadPage() {
  displayItemOnHighRating();
  getItem();
}
window.onload = loadPage;
