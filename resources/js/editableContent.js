// src/directives/editableContent.js
import { EventBus } from './../eventBus.js';

function applyEditableContent(el) {
  if (el.classList.contains('editable-content')) {
    // Create the wrapping div
    const wrapper = document.createElement('div');
    wrapper.classList.add('editable-wrap');

    // Create the delete button
    const deleteButton = document.createElement('button');
    deleteButton.innerText = 'Delete';
    deleteButton.classList.add('delete-button');
    deleteButton.addEventListener('click', () => {
      EventBus.$emit('openModalDelete', { element: el, text: el.textContent });
    });

    // Create the edit button
    const editButton = document.createElement('button');
    editButton.innerText = 'Edit';
    editButton.classList.add('edit-button');
    editButton.addEventListener('click', () => {
      EventBus.$emit('openModal', { element: el, text: el.textContent });
    });

    // Append buttons to the wrapper
    wrapper.appendChild(editButton);
    wrapper.appendChild(deleteButton);

    // Append wrapper to the DOM
    el.after(wrapper);

    // Add hover event listeners
    el.addEventListener('mouseenter', () => {
      const parentSection = el.closest('section');
      const sectionRect = parentSection.getBoundingClientRect();
      wrapper.style.position = 'absolute';
      wrapper.style.top = `${el.offsetTop}px`;
      wrapper.style.left = `${sectionRect.left + el.offsetWidth}px`;
      if (el.nodeName == 'IMG') {
        wrapper.style.left = `${el.offsetWidth}px`;
      }
    });
  }
}

export default {
  inserted(el) {
    applyEditableContent(el);
  },
};

export { applyEditableContent };
