#!/bin/sh

######GUIDE######
# 1. set your path to your root folder that includes projects you want to pull
# 2. optional: define repositories (only the given repositories will be pulled!)
# 3. run script
# 3.1 pull selective repositories >> ./gitPull.sh
# 3.2 pull all repositories of subdirectories >> ./gitPull.sh -r
#################

######MacOS GUIDE######
# open terminal and run the following code to grant permission to run the script
# >> chmod u+x gitPull.sh
# run the script as described in GUIDE above
#######################

#***(1.)***
dir="PATH/TO/FOLDER"

if [[ ${1} = "-r" || ${1} = "-R" ]] #run all sub folders
then
  cd "${dir}"
  repositorys=(*/)

  for ((i=0;i<${#repositorys[@]};i++)); do
      repositorys[i]="${dir}${repositorys[i]}"
  done
else
  #***(2.)***
  repositorys=(
  "${dir}subfolder1"
  "${dir}subfolder2"
  "${dir}subfolder3"
  "${dir}subfoldern"
  )
fi

########################################
######## DO NOT EDIT CODE BELOW ########
########################################

tagger="FALSE"

echo "\n\n*****starting gitPull.sh*****"
echo "updating " ${#repositorys[@]} "repositories..."

for repo in "${!repositorys[@]}"
do
  if [ -d "${repositorys[$repo]}" ] # repository exists
  then
    if [ -d "${repositorys[$repo]}/.git" ] # .git exists
    then

      counter=$((${repo}+1))
      cd "${repositorys[$repo]}"

      if [ $tagger = "FALSE" ]
      then
        #http or ssh based on first repository
        var=$(git remote -v | grep "http")
        if [ -z ${var} ]
        then
          ssh-add #ssh passphrase only required once in session
        else
          git config credential.helper cache #http usr+pw only required once in session
        fi
        tagger="TRUE"
      fi

      echo "---updating ($counter/${#repositorys[@]}) ${PWD##*/}---"
      git pull
    else
      echo "---no git project (${repositorys[$repo]}.git not found)---"
    fi
  else
    echo ${repositorys[$repo]} "is no directory!"
  fi
done

echo "*****************************\n\n"
