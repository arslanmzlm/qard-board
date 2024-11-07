import "toastify-js/src/toastify.css"
import ClipboardJS from "clipboard"
import Toastify from "toastify-js"
import colors from "tailwindcss/colors.js"
import {formatIncompletePhoneNumber} from "libphonenumber-js"

document.addEventListener("DOMContentLoaded", () => {
    function showModal(modal) {
        modal.classList.remove('hidden')
        modal.classList.add('grid')

        document.body.style.overflow = 'hidden'
    }

    function hideModal(modal) {
        modal.classList.remove('grid')
        modal.classList.add('hidden')

        document.body.style.overflow = 'initial'
    }

    const bankButtons = document.querySelectorAll('.bank-btn')
    const bankModal = document.getElementById('bankModal')
    const bankModalBack = document.getElementById('bankModalBack')
    const bankModalBody = document.getElementById('bankModalBody')

    if (bankButtons && bankButtons.length && bankModal) {
        bankButtons.forEach((bank) => {
            bank.addEventListener('click', (e) => {
                bankModalBody.querySelector('#bankModalTitle').textContent = bank.dataset.title
                bankModalBody.querySelector('#bankModalName span').textContent = bank.dataset.name
                bankModalBody.querySelector('#bankModalName button').dataset.clipboardText = bank.dataset.name
                bankModalBody.querySelector('#bankModalIban span').textContent = bank.dataset.iban
                bankModalBody.querySelector('#bankModalIban button').dataset.clipboardText = bank.dataset.iban
                showModal(bankModal)
            })
        })
    }

    const cardButtons = document.querySelectorAll('.card-btn')
    const cardModal = document.getElementById('cardModal')
    const cardModalBack = document.getElementById('cardModalBack')
    const cardModalBody = document.getElementById('cardModalBody')
    const cardModalFields = document.getElementById('cardModalFields')

    if (cardButtons && cardButtons.length) {
        cardButtons.forEach((card) => {
            card.addEventListener('click', (e) => {
                const fields = JSON.parse(card.dataset.value)
                cardModalFields.innerHTML = ""
                cardModalBody.querySelector('#cardModalTitle').textContent = card.dataset.title

                fields.forEach((field) => {
                    if (field.value) {
                        const div = document.createElement('div')
                        let html = `<div class="mb-2 text-xl font-bold text-blue-600">${field.label}</div>
                            <div class="flex items-center text-lg">
                                <span class="mr-1">${field.value}</span>`
                        if (field.copy) {
                            html += `<button type="button" class="clipboard-btn" data-clipboard-text="${field.value}">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-5">
                                        <path
                                            d="M15 3V6.4C15 6.96005 15 7.24008 15.109 7.45399C15.2049 7.64215 15.3578 7.79513 15.546 7.89101C15.7599 8 16.0399 8 16.6 8H20M10 8H6C4.89543 8 4 8.89543 4 10V19C4 20.1046 4.89543 21 6 21H12C13.1046 21 14 20.1046 14 19V16M16 3H13.2C12.0799 3 11.5198 3 11.092 3.21799C10.7157 3.40973 10.4097 3.71569 10.218 4.09202C10 4.51984 10 5.0799 10 6.2V12.8C10 13.9201 10 14.4802 10.218 14.908C10.4097 15.2843 10.7157 15.5903 11.092 15.782C11.5198 16 12.0799 16 13.2 16H16.8C17.9201 16 18.4802 16 18.908 15.782C19.2843 15.5903 19.5903 15.2843 19.782 14.908C20 14.4802 20 13.9201 20 12.8V7L16 3Z"
                                            stroke="#000000" stroke-width="2" stroke-linejoin="round" class="stroke-gray-700"/>
                                    </svg>
                                </button>`
                        }
                        html += `</div>`
                        div.innerHTML = html
                        cardModalFields.append(div)
                    }

                    showModal(cardModal)
                })
            })
        })
    }

    if (bankModal || cardModal) {
        document.onkeydown = function (evt) {
            if (bankModal && bankModal.classList.contains('grid')) {
                if (evt.keyCode === 27) {
                    hideModal(bankModal)
                }
            }

            if (cardModal && cardModal.classList.contains('grid')) {
                if (evt.keyCode === 27) {
                    hideModal(cardModal)
                }
            }
        }

        if (bankModal) {
            bankModal.querySelectorAll('.close').forEach((close) => {
                close.addEventListener('click', () => {
                    hideModal(bankModal)
                })
            })

            if (bankModalBack) {
                bankModalBack.addEventListener('click', e => {
                    hideModal(bankModal)
                })
            }
        }

        if (cardModal) {
            cardModal.querySelectorAll('.close').forEach((close) => {
                close.addEventListener('click', () => {
                    hideModal(cardModal)
                })
            })

            if (cardModalBack) {
                cardModalBack.addEventListener('click', e => {
                    hideModal(cardModal)
                })
            }
        }
    }

    const clipboard = new ClipboardJS('.clipboard-btn')
    clipboard.on('success', function (e) {
        Toastify({
            text: "Kopyalandı",
            duration: 1250,
            gravity: "bottom",
            position: "center",
            stopOnFocus: true,
            style: {
                background: colors.slate["500"],
            },
            offset: {
                y: 80
            },
        }).showToast()

        e.clearSelection()
    })

    const phones = document.querySelectorAll('.phone')
    if (phones && phones.length) {
        phones.forEach((el) => {
            el.textContent = formatIncompletePhoneNumber(el.textContent, "TR")
        })
    }
})
