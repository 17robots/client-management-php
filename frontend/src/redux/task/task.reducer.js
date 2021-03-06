import { ADD_TASK, REMOVE_TASK, EDIT_TASK, START_CREATE, STOP_CREATE, START_EDIT, STOP_EDIT, SELECT_TASK, DESELECT_TASK, FETCH_TASKS } from './task.types'

const INITIAL_STATE = {
  tasks: [],
  selectedTask: null,
  isCreating: false,
  isEditing: false
}

export const taskReducer = (state = INITIAL_STATE, action) => {
  switch (action.type) {
    case ADD_TASK:
      let updatedTasks = [...state.tasks]
      let body = {
        action: "addClient",
        creatorid: action.creator,
        projectid: action.project,
        milestoneid: action.milestone,
        title: action.title,
        description: action.description
      }

      fetch('http://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json())
        .then(resData => {
          if (resData.error) {
            console.log(resData.error)
            return state
          } else {
            updatedTasks.push({
              id: resData.id,
              creatorid: resData.creatorId,
              projectid: resData.projectid,
              milestoneid: resData.milestoneId,
              title: resData.title,
              description: resData.description,
              completed: false
            })
          }
        })
      return {
        ...state,
        tasks: updatedTasks,
        isCreating: false
      }
    case EDIT_TASK:
      updatedTasks = [...state.tasks]
      body = {
        action: "updateTask",
        id: state.selectedTask.id,
        projectid: action.projectid,
        milestoneid: action.milestoneid,
        title: action.title,
        description: action.description,
        completed: action.completed
      }

      fetch('https://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json())
        .then(resData => {
          if (resData.error) {
            console.log(resData.error)
            return state
          } else {
            updatedTasks[updatedTasks.indexOf(updatedTasks.find(e => e.id === state.selectedTask.id))] = {
              ...updatedTasks[updatedTasks.indexOf(updatedTasks.find(e => e.id === state.selectedTask.id))],
              projectid: action.projectid,
              milestoneid: action.milestoneid,
              title: action.title,
              description: action.description,
              completed: action.completed
            }
          }
        })
      return {
        ...state,
        tasks: updatedTasks,
        isEditing: false,
        selectedTask: null
      }
    case REMOVE_TASK:
      updatedTasks = [...state.tasks]
      body = {
        action: "deleteTask",
        id: action.id
      }

      fetch('http://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json())
        .then(resData => {
          if (resData.success) {
            updatedTasks = updatedTasks.filter(item => item.id !== state.selectedTask.id)
          } else {
            console.log(resData.error)
            return state
          }
        })
      return {
        ...state,
        selectedTask: null,
        tasks: updatedTasks
      }
    case START_CREATE:
      return {
        ...state,
        isCreating: true
      }
    case STOP_CREATE:
      return {
        ...state,
        isCreating: false
      }
    case START_EDIT:
      let selectedTask = state.tasks.find(e => e.id === action.id)
      return {
        ...state,
        isEditing: true,
        selectedTask
      }
    case STOP_EDIT:
      return {
        ...state,
        isEditing: false,
        selectedTask: null
      }
    case SELECT_TASK:
      selectedTask = state.tasks.find(e => e.id === action.id)
      return {
        ...state,
        selectedTask
      }
    case DESELECT_TASK:
      return {
        ...state,
        selectedTask: null
      }
    case FETCH_TASKS:
      let tasks = []
      body = {
        action: "getTasks",
        options: action.options
      }

      fetch('http://localhost/isp/project/controller/Controller.php', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
          'Content-Type': 'application/json; charset=UTF-8'
        }
      })
        .then(res => res.json())
        .then(resData => {
          if (resData.error) {
            console.log(resData.error)
            return state
          } else {
            tasks = resData
          }
        })
      return {
        ...state,
        tasks
      }
    default:
      return state
  }
}
