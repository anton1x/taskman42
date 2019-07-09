import React from 'react';
import $ from 'jquery';
import 'bootstrap';
import ListItem from "./ListItem";


class GroupListItem extends React.Component
{

    static defaultProps = {
        onGroupItemChange: ()=>false
    };

    fictiveUser = {
        id: -1,
        name: 'all',
        rights: []
    };

    constructor(props)
    {
        super(props);

        this.state = ({
            rights: [],
        });
        this.handleListItemChange = this.handleListItemChange.bind(this);
    }



    getFictiveUser()
    {
        return {
            id: -1,
            name: 'all',
            rights: this.state.rights
        }
    }

    handleListItemChange(user_id, rights)
    {
        this.setState({
           rights: rights
        }, () => {
            this.props.onGroupItemChange(rights);
        });

    }



    render(){
        return (
            <ListItem
                onChange={this.handleListItemChange}
                hierarchy={this.props.hierarchy}
                user={{
                    id: -1,
                    name: 'all',
                    rights: this.state.rights
                }}
            >
                С выбранными
            </ListItem>
        );
    }
}

export default GroupListItem;