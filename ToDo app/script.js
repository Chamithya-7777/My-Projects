const TASKS_KEY = 'todoTasks';
const THEME_KEY = 'theme';

let tasks = [];

// Elements
const addBtn = document.getElementById('addBtn');
const taskInput = document.getElementById('taskInput');
const taskList = document.getElementById('taskList');
const darkModeBtn = document.getElementById('darkModeBtn');

// Load tasks from localStorage
function loadTasks() {
  const raw = localStorage.getItem(TASKS_KEY);
  if (raw) {
    try {
      tasks = JSON.parse(raw) || [];
    } catch {
      tasks = [];
    }
  } else {
    tasks = [];
  }
}

// Save tasks to localStorage
function saveTasks() {
  localStorage.setItem(TASKS_KEY, JSON.stringify(tasks));
}

// Render tasks into the list
function renderTasks() {
  taskList.innerHTML = '';
  tasks.forEach((text, idx) => {
    const li = document.createElement('li');

    const span = document.createElement('span');
    span.textContent = text;
    li.appendChild(span);

    const deleteBtn = document.createElement('button');
    deleteBtn.textContent = 'Delete';
    deleteBtn.classList.add('delete');
    deleteBtn.addEventListener('click', () => {
      tasks.splice(idx, 1);
      saveTasks();
      renderTasks();
    });

    li.appendChild(deleteBtn);
    taskList.appendChild(li);
  });
}

// Add new task
addBtn.addEventListener('click', function() {
  const value = taskInput.value.trim();
  if (!value) {
    alert('⚠️ Please enter a task!');
    return;
  }
  tasks.push(value);
  saveTasks();
  renderTasks();
  taskInput.value = '';
});

// Optionally allow Enter to add
taskInput.addEventListener('keydown', function(e) {
  if (e.key === 'Enter') addBtn.click();
});

// Live time updater
function updateTime() {
  const now = new Date();
  const timeString = now.toLocaleTimeString();
  document.getElementById('time').textContent = '⏰ ' + timeString;
}
setInterval(updateTime, 1000);
updateTime();

// Theme (dark mode) persistence
function setTheme(isDark) {
  document.body.classList.toggle('dark-mode', isDark);
  try {
    localStorage.setItem(THEME_KEY, isDark ? 'dark' : 'light');
  } catch {}
  if (darkModeBtn) darkModeBtn.textContent = isDark ? '☀️' : '🌙';
}

if (darkModeBtn) {
  // initialize theme
  const savedTheme = localStorage.getItem(THEME_KEY);
  if (savedTheme) {
    setTheme(savedTheme === 'dark');
  } else {
    setTheme(false);
  }

  darkModeBtn.addEventListener('click', () => {
    const nowDark = document.body.classList.toggle('dark-mode');
    setTheme(nowDark);
  });
}

// Init
loadTasks();
renderTasks();
