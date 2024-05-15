import { Flipper } from 'flip-toolkit'

/**
 * @property {HTMLElement} pagination
 * @property {HTMLElement} content
 * @property {HTMLElement} sorting
 * @property {HTMLFormElement} form
 */

export default class Filter {
  /**
   *
   * @param {HTMLElement|null} element
   */
  constructor(element) {
    if (element === null) {
      return
    }
    this.pagination = element.querySelector('.js-filter-pagination')
    this.content = element.querySelector('.js-filter-content')
    this.sorting = element.querySelector('.js-filter-sorting')
    this.form = element.querySelector('.js-filter-form')
    this.bindEvents()
  }
  /**add behaviors to new elements */
  bindEvents() {
    const aClickListener = (e) => {
      if (e.target.tagName === 'A') {
        e.preventDefault()
        this.loadUrl(e.target.getAttribute('href'))
      }
    }
    this.sorting.addEventListener('click', (e) => {
      aClickListener(e)
      this.page = 1
    })
    this.pagination.addEventListener('click', aClickListener)
    this.form.querySelectorAll('input').forEach((input) => {
      input.addEventListener('change', this.loadForm.bind(this))
    })
  }

  async loadForm() {
    this.page = 1
    const data = new FormData(this.form)

    //convert data from form and send to url
    const url = new URL(
      this.form.getAttribute('action') || window.location.href
    )

    //create the url dynamically
    const params = new URLSearchParams()
    data.forEach((value, key) => {
      params.append(key, value)
    })
    //return  the begin of url '/our-products'(pathname) and add the parameters
    return this.loadUrl(url.pathname + '?' + params.toString())
  }

  async loadUrl(url) {
    //loader
    this.showLoader()
    const params = new URLSearchParams(url.split('?')[1] || '')
    params.set('ajax', 1)
    const response = await fetch(url.split('?')[0] + '?' + params.toString(), {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      },
    })
    if (response.status >= 200 && response.status < 300) {
      const data = await response.json()
      this.content.innerHTML = data.content
      this.sorting.innerHTML = data.sorting
      this.pagination.innerHTML = data.pagination

      //update price filter according to product search
      this.updatePrices(data)
      params.delete('ajax')
      history.replaceState({}, '', url.split('?')[0] + '?' + params.toString())
    } else {
      console.error(response)
    }
    this.hideLoader()
  }

  // LOADER FORM FILTER
  showLoader() {
    this.form.classList.add('is-loading')
    const loader = this.form.querySelector('.js-loading')
    if (loader === null) {
      return
    }
    loader.setAttribute('aria-hidden', 'false')
    loader.style.display = null
  }
  hideLoader() {
    this.form.classList.remove('is-loading')
    const loader = this.form.querySelector('.js-loading')
    if (loader === null) {
      return
    }
    loader.setAttribute('aria-hidden', 'true')
    loader.style.display = 'none'
  }

  updatePrices({ min, max }) {
    const slider = document.getElementById('price-slider')
    if (slider === null) {
      return
    }

    //update value of prices inside the form
    slider.noUiSlider.updateOptions({
      range: {
        min: [min],
        max: [max],
      },
    })
  }
}
