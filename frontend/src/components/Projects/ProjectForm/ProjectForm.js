import React from 'react'
import connect from 'react-redux'
import { addProject } from '../../../redux/project/project.actions'

const mapDispatchToProps = dispatch => ({
  addProject: projectData => dispatch(addProject(projectData))
})

class ProjectForm extends React.Component {
  constructor(props) {
    super(props)

  }
}

export default connect(null, mapDispatchToProps)(ProjectForm)