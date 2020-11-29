import React from 'react'

export default class Projects extends React.Component {
  constructor(props) {
    super(props)
  }

  state = {
    selectedProject: null,
    isAddProject: false,
    isEditProject: false,
    isAddMilestone: false,
    isEditMilestone: false,
    isAddTask: false,
    isEditTask: false,
    selectedTask: null,
    selectedMilestone: null
  }
}