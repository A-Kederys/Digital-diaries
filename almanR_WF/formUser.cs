using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace almanR
{
    public partial class formUser : Form
    {

        private readonly formUserInfo _parent;
        public string id, fname, lname, email, admin;

        private void btnCancel_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        public formUser(formUserInfo parent)
        {
            InitializeComponent();
            _parent = parent;
        }

        public void updateInfo()
        {
            lbltext.Text = "Update user";
            btnSave.Text = "Edit";
            txtFname.Text = fname;
            txtLname.Text = lname;
            txtEmail.Text = email;
            comboBox1.Text = admin;
        }

        public void Clear()
        {
            txtFname.Text = txtLname.Text = txtEmail.Text = comboBox1.Text = string.Empty;
        }

        private void btnSave_Click(object sender, EventArgs e)
        {
            bool containsIntF = txtFname.Text.Trim().Any(char.IsDigit);
            bool containsIntL = txtLname.Text.Trim().Any(char.IsDigit);
            if (txtFname.Text.Trim().Length < 3 || containsIntF)
            {
                MessageBox.Show("Users first name should be more than 2 letters without numbers!", "Error:", MessageBoxButtons.OK, MessageBoxIcon.Information);
                return;
            }
            else if (txtLname.Text.Trim().Length < 3 || containsIntL)
            {
                MessageBox.Show("Users last name should be more than 2 letters without numbers!", "Error:", MessageBoxButtons.OK, MessageBoxIcon.Information);
                return;
            }
            else if (txtEmail.Text.Trim().Length < 5 || !txtEmail.Text.Contains("@"))
            {
                MessageBox.Show("Users email should contain @ character and have more thant 4 characters", "Error:", MessageBoxButtons.OK, MessageBoxIcon.Information);
                return;
            }
            //if (!txtRole.Text.All(char.IsDigit))
            //{
                //MessageBox.Show("Users role should contain integers");
                //return;
            //}
            //if (Int32.Parse(txtRole.Text) >= 2 || Int32.Parse(txtRole.Text) < 0)
            //{
                //MessageBox.Show("Role should be 1 or 0");
                //return;
            //}

            if (btnSave.Text == "Edit")
            {
                if (comboBox1.Text == "Admin")
                {
                    user usr = new user(txtFname.Text.Trim(), txtLname.Text.Trim(), txtEmail.Text.Trim(), 1);
                    DBuser.editUser(usr, id);
                }
                if (comboBox1.Text == "User")
                {
                    user usr = new user(txtFname.Text.Trim(), txtLname.Text.Trim(), txtEmail.Text.Trim(), 0);
                    DBuser.editUser(usr, id);
                }

            }    
            _parent.Display();

        }
    }
}
