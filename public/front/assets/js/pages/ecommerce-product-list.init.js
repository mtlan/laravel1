var previewTemplate,
    dropzone,
    perPage = 10,
    editlist = !1,
    checkAll = document.getElementById("checkAll"),
    options =
        (checkAll &&
            (checkAll.onclick = function () {
                for (
                    var e = document.querySelectorAll(
                            '.form-check-all input[type="checkbox"]'
                        ),
                        t = document.querySelectorAll(
                            '.form-check-all input[type="checkbox"]:checked'
                        ).length,
                        i = 0;
                    i < e.length;
                    i++
                )
                    (e[i].checked = this.checked),
                        e[i].checked
                            ? e[i].closest("tr").classList.add("table-active")
                            : e[i]
                                  .closest("tr")
                                  .classList.remove("table-active"),
                        e[i].closest("tr").classList.contains("table-active"),
                        0 < t
                            ? document
                                  .getElementById("remove-actions")
                                  .classList.add("d-none")
                            : document
                                  .getElementById("remove-actions")
                                  .classList.remove("d-none");
            }),
        {
            valueNames: [
                "id",
                "products",
                "discount",
                "stock",
                "price",
                "category",
                "orders",
                "rating",
                "published",
            ],
            page: perPage,
            pagination: !0,
            plugins: [ListPagination({ left: 2, right: 2 })],
        }),
    dropzonePreviewNode = document.querySelector("#dropzone-preview-list"),
    productList =
        ((dropzonePreviewNode.id = ""),
        dropzonePreviewNode &&
            ((previewTemplate = dropzonePreviewNode.parentNode.innerHTML),
            dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode),
            (dropzone = new Dropzone("div.my-dropzone", {
                url: "https://httpbin.org/post",
                method: "post",
                previewTemplate: previewTemplate,
                previewsContainer: "#dropzone-preview",
            }))),
        new List("productList", options).on("updated", function (e) {
            0 == e.matchingItems.length
                ? (document.getElementsByClassName(
                      "noresult"
                  )[0].style.display = "block")
                : (document.getElementsByClassName(
                      "noresult"
                  )[0].style.display = "none");
            var t = 1 == e.i,
                i = e.i > e.matchingItems.length - e.page;
            document.querySelector(".pagination-prev.disabled") &&
                document
                    .querySelector(".pagination-prev.disabled")
                    .classList.remove("disabled"),
                document.querySelector(".pagination-next.disabled") &&
                    document
                        .querySelector(".pagination-next.disabled")
                        .classList.remove("disabled"),
                t &&
                    document
                        .querySelector(".pagination-prev")
                        .classList.add("disabled"),
                i &&
                    document
                        .querySelector(".pagination-next")
                        .classList.add("disabled"),
                e.matchingItems.length <= perPage
                    ? (document.getElementById(
                          "pagination-element"
                      ).style.display = "none")
                    : (document.getElementById(
                          "pagination-element"
                      ).style.display = "flex"),
                e.matchingItems.length == perPage &&
                    document
                        .querySelector(".pagination.listjs-pagination")
                        .firstElementChild.children[0].click(),
                0 < e.matchingItems.length
                    ? (document.getElementsByClassName(
                          "noresult"
                      )[0].style.display = "none")
                    : (document.getElementsByClassName(
                          "noresult"
                      )[0].style.display = "block");
        }));
const xhttp = new XMLHttpRequest();
(xhttp.onload = function () {
    var e = JSON.parse(this.responseText);
    Array.from(e).forEach(function (e) {
        productList.add({
            id: `<a href="javascript:void(0);" class="fw-medium link-primary">#TB${e.id}</a>`,
            products:
                '<div class="d-flex align-items-center">                <div class="avatar-xs bg-light rounded p-1 me-2">                    <img src="' +
                e.product[0].img +
                '" alt="' +
                e.product[0].img_alt +
                '" class="img-fluid d-block product-img">                </div>                <div>                    <h6 class="mb-0"><a href="apps-ecommerce-product-details.html" class="text-reset text-capitalize product-title">' +
                e.product[0].title +
                "</a></h6>                </div>            </div>",
            discount: e.discount,
            category: e.category,
            stock: e.stock,
            price: e.price,
            orders: e.orders,
            rating:
                '<span class="badge bg-warning-subtle text-warning"><i class="bi bi-star-fill align-baseline me-1"></i> <span class="rate">' +
                e.ratings +
                "</span></span>",
            published: e.publish,
        }),
            productList.sort("id", { order: "desc" });
    }),
        productList.remove(
            "id",
            '<a href="javascript:void(0);" class="fw-medium link-primary">#TB01</a>'
        ),
        refreshCallbacks(),
        ischeckboxcheck();
}),
    xhttp.open("GET", "assets/json/product-list.json"),
    xhttp.send(),
    (isCount = new DOMParser().parseFromString(
        productList.items.slice(-1)[0]._values.id,
        "text/html"
    )),
    document
        .querySelector(".pagination-next")
        .addEventListener("click", function () {
            document.querySelector(".pagination.listjs-pagination") &&
                document
                    .querySelector(".pagination.listjs-pagination")
                    .querySelector(".active") &&
                null !=
                    document
                        .querySelector(".pagination.listjs-pagination")
                        .querySelector(".active").nextElementSibling &&
                document
                    .querySelector(".pagination.listjs-pagination")
                    .querySelector(".active")
                    .nextElementSibling.children[0].click();
        }),
    document
        .querySelector(".pagination-prev")
        .addEventListener("click", function () {
            document.querySelector(".pagination.listjs-pagination") &&
                document
                    .querySelector(".pagination.listjs-pagination")
                    .querySelector(".active") &&
                null !=
                    document
                        .querySelector(".pagination.listjs-pagination")
                        .querySelector(".active").previousSibling &&
                document
                    .querySelector(".pagination.listjs-pagination")
                    .querySelector(".active")
                    .previousSibling.children[0].click();
        });
var idField = document.getElementById("id-field"),
    productTitleField = document.getElementById("product-title-input"),
    productCategoryField = document.getElementById("product-category-input"),
    productStockField = document.getElementById("product-stock-input"),
    productPriceField = document.getElementById("product-price-input"),
    removeBtns = document.getElementsByClassName("remove-item-btn"),
    editBtns = document.getElementsByClassName("edit-item-btn"),
    date = (refreshCallbacks(), new Date().toUTCString().slice(5, 16)),
    categoryVal = new Choices(productCategoryField, { searchEnabled: !1 }),
    count = 13,
    forms = document.querySelectorAll(".tablelist-form");
function ischeckboxcheck() {
    Array.from(document.getElementsByName("chk_child")).forEach(function (i) {
        i.addEventListener("change", function (e) {
            1 == i.checked
                ? e.target.closest("tr").classList.add("table-active")
                : e.target.closest("tr").classList.remove("table-active");
            var t = document.querySelectorAll(
                '[name="chk_child"]:checked'
            ).length;
            e.target.closest("tr").classList.contains("table-active"),
                0 < t
                    ? document
                          .getElementById("remove-actions")
                          .classList.remove("d-none")
                    : document
                          .getElementById("remove-actions")
                          .classList.add("d-none");
        });
    });
}
function refreshCallbacks() {
    removeBtns &&
        Array.from(removeBtns).forEach(function (e) {
            e.addEventListener("click", function (e) {
                e.target.closest("tr").children[1].innerText,
                    (itemId = e.target.closest("tr").children[1].innerText);
                e = productList.get({ id: itemId });
                Array.from(e).forEach(function (e) {
                    var t = (deleteid = new DOMParser().parseFromString(
                        e._values.id,
                        "text/html"
                    )).body.firstElementChild;
                    deleteid.body.firstElementChild.innerHTML == itemId &&
                        document
                            .getElementById("delete-record")
                            .addEventListener("click", function () {
                                productList.remove("id", t.outerHTML),
                                    document
                                        .getElementById("deleteRecord-close")
                                        .click();
                            });
                });
            });
        }),
        editBtns &&
            Array.from(editBtns).forEach(function (e) {
                e.addEventListener("click", function (e) {
                    e.target.closest("tr").children[1].innerText,
                        (itemId = e.target.closest("tr").children[1].innerText);
                    e = productList.get({ id: itemId });
                    Array.from(e).forEach(function (e) {
                        var t,
                            i = (isid = new DOMParser().parseFromString(
                                e._values.id,
                                "text/html"
                            )).body.firstElementChild.innerHTML;
                        i == itemId &&
                            ((editlist = !0),
                            (idField.value = i),
                            (i = new DOMParser().parseFromString(
                                e._values.products,
                                "text/html"
                            )),
                            (productTitleField.value =
                                i.querySelector(".product-title").innerHTML),
                            (document.getElementById(
                                "dropzone-preview"
                            ).innerHTML = ""),
                            (t = {
                                name: i.body
                                    .querySelector("img")
                                    .getAttribute("alt"),
                                size: 12345,
                            }),
                            dropzone.options.addedfile.call(dropzone, t),
                            dropzone.options.thumbnail.call(
                                dropzone,
                                t,
                                i.body.querySelector("img").src
                            ),
                            categoryVal && categoryVal.destroy(),
                            (categoryVal = new Choices(productCategoryField, {
                                searchEnabled: !1,
                            })),
                            (t = e._values.category),
                            categoryVal.setChoiceByValue(t),
                            (productStockField.value = e._values.stock),
                            (i = e._values.price.split("$")),
                            (productPriceField.value = i[1]),
                            (t = new DOMParser().parseFromString(
                                e._values.rating,
                                "text/html"
                            )),
                            (document.getElementById("order-field").value =
                                e._values.orders),
                            (document.getElementById("rating-field").value =
                                t.querySelector(".rate").innerHTML));
                    });
                });
            });
}
function clearFields() {
    (idField.value = ""),
        (productTitleField.value = ""),
        (productStockField.value = ""),
        (productPriceField.value = ""),
        document.getElementById("dropzone-preview") &&
            (document.getElementById("dropzone-preview").innerHTML = ""),
        categoryVal &&
            (categoryVal.destroy(),
            (categoryVal = new Choices(productCategoryField))),
        (document.getElementById("order-field").value = ""),
        (document.getElementById("rating-field").value = ""),
        (document.getElementById("discount-field").value = "");
}
function deleteMultiple() {
    ids_array = [];
    var e,
        t = document.getElementsByName("chk_child");
    for (i = 0; i < t.length; i++)
        1 == t[i].checked &&
            ((e =
                t[i].parentNode.parentNode.parentNode.querySelector(
                    "td a"
                ).innerHTML),
            ids_array.push(e));
    "undefined" != typeof ids_array && 0 < ids_array.length
        ? Swal.fire({
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              icon: "warning",
              showCancelButton: !0,
              confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
              cancelButtonClass: "btn btn-danger w-xs mt-2",
              confirmButtonText: "Yes, delete it!",
              buttonsStyling: !1,
              showCloseButton: !0,
          }).then(function (e) {
              if (e.value) {
                  for (i = 0; i < ids_array.length; i++)
                      productList.remove(
                          "id",
                          `<a href="javascript:void(0);" class="fw-medium link-primary">${ids_array[i]}</a>`
                      );
                  document
                      .getElementById("remove-actions")
                      .classList.add("d-none"),
                      (document.getElementById("checkAll").checked = !1),
                      Swal.fire({
                          title: "Deleted!",
                          text: "Your data has been deleted.",
                          icon: "success",
                          confirmButtonClass: "btn btn-info w-xs mt-2",
                          buttonsStyling: !1,
                      });
              }
          })
        : Swal.fire({
              title: "Please select at least one checkbox",
              confirmButtonClass: "btn btn-info",
              buttonsStyling: !1,
              showCloseButton: !0,
          });
}
function filterData() {
    var r = document.getElementById("idDiscount").value,
        n = document.getElementById("idCategory").value;
    productList.filter(function (e) {
        var t = !1,
            i = !1,
            l = e.values().discount.split("%"),
            i =
                "all" == e.values().category ||
                "all" == n ||
                e.values().category == n;
        if (
            (t =
                "all" == l ||
                "all" == r ||
                ("0" == r ? parseFloat(l[0]) < 10 : parseFloat(l[0]) >= r)) &&
            i
        )
            return t && i;
    }),
        productList.update();
}
Array.prototype.slice.call(forms).forEach(function (e) {
    e.addEventListener("submit", function (e) {
        e.preventDefault(),
            document.querySelector(".dz-image-preview") &&
                (t = new DOMParser()
                    .parseFromString(
                        document.querySelectorAll(".dz-image-preview")[0]
                            .innerHTML,
                        "text/html"
                    )
                    .body.querySelector("[data-dz-thumbnail]"));
        var t,
            i = document.getElementById("alert-error-msg");
        return (
            i.classList.remove("d-none"),
            setTimeout(() => i.classList.add("d-none"), 2e3),
            "" == productTitleField.value
                ? !(i.innerHTML = "Please enter a product title")
                : 0 == document.querySelectorAll(".dz-image-preview").length
                ? !(i.innerHTML = "Please select a product images")
                : "" == productCategoryField.value
                ? !(i.innerHTML = "Please select a products category")
                : "" == productStockField.value
                ? !(i.innerHTML = "Please enter a product stocks")
                : "" == productPriceField.value
                ? !(i.innerHTML = "Please enter a product price")
                : ("" !== productTitleField.value &&
                  "" !== productCategoryField.value &&
                  "" !== productStockField.value &&
                  "" !== productPriceField.value &&
                  0 < document.querySelectorAll(".dz-image-preview").length &&
                  !editlist
                      ? (productList.add({
                            id:
                                '<a href="javascript:void(0);" class="fw-medium link-primary">#TBT' +
                                count +
                                "</a>",
                            products:
                                '<div class="d-flex align-items-center">                    <div class="avatar-xs bg-light rounded p-1 me-2">                        <img src="' +
                                t.src +
                                '" alt="' +
                                t.getAttribute("alt") +
                                '" class="img-fluid d-block product-img">                    </div>                    <div>                        <h6 class="mb-0"><a href="apps-ecommerce-product-details.html" class="text-reset product-title">' +
                                productTitleField.value +
                                "</a></h6>                    </div>                </div>",
                            discount:
                                document.getElementById("discount-field").value,
                            category: productCategoryField.value,
                            stock: productStockField.value,
                            price: productPriceField.value,
                            orders: "--",
                            rating: '<span class="badge bg-warning-subtle text-warning"><i class="bi bi-star-fill align-baseline me-1"></i> <span class="rate">--</span></span>',
                            published: date,
                        }),
                        productList.sort("id", { order: "desc" }),
                        document
                            .getElementById("alert-error-msg")
                            .classList.add("d-none"),
                        document.getElementById("close-modal").click(),
                        count++,
                        clearFields(),
                        refreshCallbacks(),
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Product Add successfully!",
                            showConfirmButton: !1,
                            timer: 2e3,
                            showCloseButton: !0,
                        }))
                      : "" !== productTitleField.value &&
                        "" !== productCategoryField.value &&
                        "" !== productStockField.value &&
                        "" !== productPriceField.value &&
                        0 <
                            document.querySelectorAll(".dz-image-preview")
                                .length &&
                        editlist &&
                        ((e = productList.get({ id: idField.value })),
                        Array.from(e).forEach(function (e) {
                            (isid = new DOMParser().parseFromString(
                                e._values.id,
                                "text/html"
                            )).body.firstElementChild.innerHTML == itemId &&
                                e.values({
                                    id:
                                        '<a href="javascript:void(0);" class="fw-medium link-primary">' +
                                        idField.value +
                                        "</a>",
                                    products:
                                        '<div class="d-flex align-items-center">                            <div class="avatar-xs bg-light rounded p-1 me-2">                                <img src="' +
                                        t.src +
                                        '" alt="' +
                                        t.getAttribute("alt") +
                                        '" class="img-fluid d-block product-img">                            </div>                            <div>                                <h6 class="mb-0"><a href="apps-ecommerce-product-details.html" class="text-reset product-title">' +
                                        productTitleField.value +
                                        "</a></h6>                            </div>                        </div>",
                                    discount:
                                        document.getElementById(
                                            "discount-field"
                                        ).value,
                                    category: productCategoryField.value,
                                    stock: productStockField.value,
                                    price: productPriceField.value,
                                    orders: document.getElementById(
                                        "order-field"
                                    ).value,
                                    rating:
                                        '<span class="badge bg-warning-subtle text-warning"><i class="bi bi-star-fill align-baseline me-1"></i> <span class="rate">' +
                                        document.getElementById("rating-field")
                                            .value +
                                        "</span></span>",
                                    published: date,
                                });
                        }),
                        document
                            .getElementById("alert-error-msg")
                            .classList.add("d-none"),
                        document.getElementById("close-modal").click(),
                        clearFields(),
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Order updated Successfully!",
                            showConfirmButton: !1,
                            timer: 2e3,
                            showCloseButton: !0,
                        })),
                  !0)
        );
    });
}),
    document
        .getElementById("showModal")
        .addEventListener("show.bs.modal", function (e) {
            e.relatedTarget.classList.contains("edit-item-btn")
                ? ((document.getElementById("exampleModalLabel").innerHTML =
                      "Edit product"),
                  (document
                      .getElementById("showModal")
                      .querySelector(".modal-footer").style.display = "block"),
                  (document.getElementById("add-btn").innerHTML = "Update"))
                : e.relatedTarget.classList.contains("add-btn")
                ? ((document.getElementById("exampleModalLabel").innerHTML =
                      "Add product"),
                  (document
                      .getElementById("showModal")
                      .querySelector(".modal-footer").style.display = "block"),
                  (document.getElementById("add-btn").innerHTML =
                      "Add product"))
                : ((document.getElementById("exampleModalLabel").innerHTML =
                      "List product"),
                  (document
                      .getElementById("showModal")
                      .querySelector(".modal-footer").style.display = "none"));
        }),
    document
        .getElementById("showModal")
        .addEventListener("hidden.bs.modal", function () {
            clearFields();
        });
