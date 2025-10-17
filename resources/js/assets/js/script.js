// // Simple sidebar collapse toggle
// document.addEventListener('DOMContentLoaded', function(){
//   const collapseBtn = document.getElementById('collapseBtn');
//   const sidebar = document.getElementById('sidebar');

//   collapseBtn.addEventListener('click', () => {
//     sidebar.classList.toggle('collapsed');
//     if(sidebar.classList.contains('collapsed')){
//       sidebar.style.width = '80px';
//     } else {
//       sidebar.style.width = '260px';
//     }
//   });

//   // Task checkbox demo: toggle done badge style
//   document.querySelectorAll('.task input[type="checkbox"]').forEach(chk => {
//     chk.addEventListener('change', (e) => {
//       const li = e.target.closest('.task');
//       const badge = li.querySelector('.badge');
//       if(e.target.checked){
//         badge.textContent = 'Done';
//         badge.className = 'badge done';
//       } else {
//         badge.textContent = 'In Progress';
//         badge.className = 'badge inprogress';
//       }
//     });
//   });
// });
