import './styles/app.scss'

//ui slider for price of product
import noUiSlider from 'nouislider'
import 'nouislider/dist/nouislider.css'

import Filter from './modules/Filter'

new Filter(document.querySelector('.js-filter'))

const slider = document.getElementById('price-slider')

if (slider) {
  const min = document.getElementById('min')
  const max = document.getElementById('max')

  const minValue = Math.floor(parseInt(slider.dataset.min, 10) / 10) * 10
  const maxValue = Math.ceil(parseInt(slider.dataset.max, 10) / 10) * 10
  const range = noUiSlider.create(slider, {
    start: [min.value || minValue, max.value || maxValue],
    connect: true,
    step: 2, //if products so expensive, step 10, or 100 or 200 etc.
    range: {
      min: minValue,
      max: maxValue,
    },
  })

  range.on('slide', function (values, handle) {
    if (handle === 0) {
      min.value = Math.round(values[0])
    }
    if (handle === 1) {
      max.value = Math.round(values[1])
    }
  })
  //to activate the min/max price from the input for the filter
  range.on('end', function (values, handle) {
    min.dispatchEvent(new Event('change'))
  })
}
