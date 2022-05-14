document.addEventListener('click', e=>{
   let parent = e.target.parentElement;
   if (parent.nodeName === 'TR'){
      parent.classList.toggle('test');
   }
});