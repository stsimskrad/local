"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Modules_Accounting_Report_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Modules/Accounting/Report/Index.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Modules/Accounting/Report/Index.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      currentUrl: window.location.origin,
      errors: [],
      allotments: [],
      expenses: [],
      list: {
        balances: [],
        allotments: [],
        disrbursements: []
      }
    };
  },
  computed: {
    sum_allotment: function sum_allotment() {
      var sum = 0;
      return this.allotments.reduce(function (acc, ele) {
        if (ele.lists_sum == null) {
          sum = 0;
        } else {
          sum = ele.lists_sum;
        }

        return acc + parseInt(sum);
      }, 0);
    },
    allotment_sum: function allotment_sum() {
      var sum = 0;
      return this.expenses.reduce(function (acc, ele) {
        if (ele.allotment_sum == null) {
          sum = 0;
        } else {
          sum = ele.allotment_sum;
        }

        return acc + parseInt(sum);
      }, 0);
    },
    balance_sum: function balance_sum() {
      var sum = 0;
      return this.expenses.reduce(function (acc, ele) {
        if (ele.balance_sum == null) {
          sum = 0;
        } else {
          sum = ele.balance_sum;
        }

        return acc + parseInt(sum);
      }, 0);
    },
    disbursement_sum: function disbursement_sum() {
      var sum = 0;
      return this.expenses.reduce(function (acc, ele) {
        if (ele.disbursement_sum == null) {
          sum = 0;
        } else {
          sum = ele.disbursement_sum;
        }

        return acc + parseInt(sum);
      }, 0);
    }
  },
  created: function created() {
    this.fetch();
  },
  methods: {
    fetch: function fetch() {
      var _this = this;

      axios.get(this.currentUrl + '/request/accounting/reports').then(function (response) {
        _this.allotments = response.data.allotments;
        _this.expenses = response.data.expenses;
      })["catch"](function (err) {
        return console.log(err);
      });
    },
    Amount: function Amount() {},
    formatAmount: function formatAmount(value) {
      var val = (value / 1).toFixed(2).replace(',', '.');
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
  }
});

/***/ }),

/***/ "./resources/js/components/Modules/Accounting/Report/Index.vue":
/*!*********************************************************************!*\
  !*** ./resources/js/components/Modules/Accounting/Report/Index.vue ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_ef9ad6a4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=ef9ad6a4& */ "./resources/js/components/Modules/Accounting/Report/Index.vue?vue&type=template&id=ef9ad6a4&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/Modules/Accounting/Report/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Index_vue_vue_type_template_id_ef9ad6a4___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_ef9ad6a4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Modules/Accounting/Report/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Modules/Accounting/Report/Index.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/Modules/Accounting/Report/Index.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Modules/Accounting/Report/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Modules/Accounting/Report/Index.vue?vue&type=template&id=ef9ad6a4&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/Modules/Accounting/Report/Index.vue?vue&type=template&id=ef9ad6a4& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_ef9ad6a4___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_ef9ad6a4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_ef9ad6a4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=ef9ad6a4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Modules/Accounting/Report/Index.vue?vue&type=template&id=ef9ad6a4&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Modules/Accounting/Report/Index.vue?vue&type=template&id=ef9ad6a4&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Modules/Accounting/Report/Index.vue?vue&type=template&id=ef9ad6a4& ***!
  \*******************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row g-0" }, [
    _c("div", { staticClass: "col-md-6" }, [
      _c("table", { staticClass: "table table-centered table-nowrap" }, [
        _vm._m(0),
        _vm._v(" "),
        _c(
          "tbody",
          _vm._l(_vm.allotments, function (list) {
            return _c("tr", { key: list.id }, [
              _c("td", { staticClass: "text-center" }, [
                _vm._v(_vm._s(list.checked_at)),
              ]),
              _vm._v(" "),
              _c("td", { staticClass: "text-center" }, [
                _vm._v(_vm._s(list.check_no)),
              ]),
              _vm._v(" "),
              _c("td", { staticClass: "text-center" }, [
                _vm._v("₱" + _vm._s(_vm.formatAmount(list.lists_sum))),
              ]),
            ])
          }),
          0
        ),
      ]),
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "col-md-6" }, [
      _c("table", { staticClass: "table table-centered table-nowrap" }, [
        _vm._m(1),
        _vm._v(" "),
        _c("tbody", [
          _c("tr", [
            _c("td", { staticClass: "text-center" }, [
              _vm._v(" " + _vm._s(_vm.formatAmount(_vm.balance_sum))),
            ]),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _vm._v(
                " " +
                  _vm._s(_vm.formatAmount(_vm.balance_sum + _vm.sum_allotment))
              ),
            ]),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _vm._v(" " + _vm._s(_vm.formatAmount(_vm.disbursement_sum))),
            ]),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _vm._v(
                " " +
                  _vm._s(
                    _vm.formatAmount(
                      _vm.balance_sum + _vm.sum_allotment - _vm.disbursement_sum
                    )
                  )
              ),
            ]),
          ]),
        ]),
      ]),
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "col-md-12",
        staticStyle: { height: "300px", overflow: "auto" },
      },
      [
        _c("table", { staticClass: "table table-centered table-nowrap" }, [
          _vm._m(2),
          _vm._v(" "),
          _c(
            "tbody",
            _vm._l(_vm.expenses, function (list) {
              return _c("tr", { key: list.id }, [
                _c("td", { staticClass: "text-center" }, [
                  _vm._v(
                    " " + _vm._s(list.name.length > 50 ? list.code : list.name)
                  ),
                ]),
                _vm._v(" "),
                _c("td", { staticClass: "text-center" }, [
                  _vm._v(
                    " " +
                      _vm._s(
                        list.balances.length > 0
                          ? _vm.formatAmount(list.balances[0].amount)
                          : "0.00"
                      )
                  ),
                ]),
                _vm._v(" "),
                _c("td", { staticClass: "text-center" }, [
                  _vm._v(
                    " " +
                      _vm._s(
                        list.allotments.length > 0
                          ? _vm.formatAmount(list.allotments[0].amount)
                          : "0.00"
                      )
                  ),
                ]),
                _vm._v(" "),
                _c("td", { staticClass: "text-center" }, [
                  _vm._v(
                    " " +
                      _vm._s(
                        list.disbursements.length > 0
                          ? _vm.formatAmount(list.disbursements[0].amount)
                          : "0.00"
                      )
                  ),
                ]),
                _vm._v(" "),
                _c("td", { staticClass: "text-center" }),
              ])
            }),
            0
          ),
        ]),
      ]
    ),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "thead-light" }, [
      _c("tr", { staticClass: "font-size-11" }, [
        _c("th", { staticClass: "text-center" }, [_vm._v("Check Date")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v("Check #")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v("Amount")]),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "thead-light" }, [
      _c("tr", { staticClass: "font-size-11" }, [
        _c("th", { staticClass: "text-center" }, [_vm._v("Previous Balance")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v("Total")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v("Disbursement")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v("Current Balance")]),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "thead-light" }, [
      _c("tr", { staticClass: "font-size-11" }, [
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { width: "40%" } },
          [_vm._v("Expense Class")]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { width: "15%" } },
          [_vm._v("Unexpended Balance")]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { width: "15%" } },
          [_vm._v("Current Release")]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { width: "15%" } },
          [_vm._v("Disbursement")]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { width: "15%" } },
          [_vm._v("Balance")]
        ),
      ]),
    ])
  },
]
render._withStripped = true



/***/ })

}]);