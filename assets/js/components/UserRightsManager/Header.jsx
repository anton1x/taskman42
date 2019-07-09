import React from 'react';
import $ from 'jquery';
import 'bootstrap';


class Header extends React.Component
{
    constructor(props)
    {
        super(props);
    }


    render(){
        let hierarchy = this.props.hierarchy;
        return (
            <thead className="">
                <tr>
                    <td key="username">Имя пользователя</td>
                    {Object.keys(hierarchy).map((key) =>
                        <td key={key}>{hierarchy[key].item.description}</td>
                    )}
                </tr>
            </thead>
        );
    }
}

export default Header;